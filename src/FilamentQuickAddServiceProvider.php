<?php

namespace Cocosmos\FilamentQuickAddSelect;

use Filament\Forms\Components\Select;
use Illuminate\Support\ServiceProvider;

class FilamentQuickAddServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load translations
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'quick-add');

        // Publish translations
        $this->publishes([
            __DIR__.'/../lang' => lang_path('vendor/quick-add'),
        ], 'quick-add-translations');

        // Register the quickAdd macro on Select component
        Select::macro('quickAdd', function (bool $enabled = true, ?string $label = null, bool $resetSearch = false) {
            /** @var Select $this */
            if (! $enabled) {
                return $this;
            }

            // Make it live to handle state changes immediately
            $this->live();

            // Store the label template
            $labelTemplate = $label ?? fn (string $search): string => __('quick-add::quick-add.add', ['term' => $search]);

            // Override getSearchResults to inject quick-add option
            $this->getSearchResultsUsing(function (Select $component, string $search) use ($labelTemplate) {
                if (empty($search)) {
                    return [];
                }

                $relationship = $component->getRelationship();
                if (! $relationship) {
                    return [];
                }

                $titleAttribute = $component->getRelationshipTitleAttribute();
                $relatedModel = $relationship->getRelated();
                $keyName = $relatedModel->getKeyName();

                // Search existing records
                $results = $relatedModel::query()
                    ->whereLike($titleAttribute, "%{$search}%")
                    ->limit(50)
                    ->pluck($titleAttribute, $keyName)
                    ->toArray();

                // Add quick-add option if search doesn't match exactly
                $exactMatch = collect($results)->contains(fn ($value) => strtolower($value) === strtolower($search));

                if (! $exactMatch) {
                    $quickAddKey = "__quick_add__{$search}";
                    $quickAddLabel = is_callable($labelTemplate)
                        ? $labelTemplate($search)
                        : str_replace('{search}', $search, $labelTemplate);

                    $results = [$quickAddKey => $quickAddLabel] + $results;
                }

                return $results;
            });

            // Listen for search reset via Livewire event (scoped to this component)
            $this->extraAlpineAttributes([
                'x-on:quick-add-created.window' => <<<'JS'
                    if ($event.detail.statePath === select.statePath) {
                        if ($event.detail.resetSearch) {
                            if (select.searchInput) select.searchInput.value = '';
                            select.searchQuery = '';
                            select.options = [];
                        } else {
                            select.options = select.options.filter(opt => !String(opt.value).startsWith('__quick_add__'));
                        }
                        select.renderOptions();
                        if (select.options.length === 0) select.showNoOptionsMessage();
                    }
                JS,
            ]);

            // Handle quick-add when state is updated
            $this->afterStateUpdated(function (Select $component, $state) use ($resetSearch) {
                if (! $state) {
                    return;
                }

                $relationship = $component->getRelationship();
                if (! $relationship) {
                    return;
                }

                $titleAttribute = $component->getRelationshipTitleAttribute();
                $model = $relationship->getRelated();
                $created = false;

                // Handle array (multiple select)
                if (is_array($state)) {
                    $newState = [];

                    foreach ($state as $key) {
                        if (is_string($key) && str_starts_with($key, '__quick_add__')) {
                            $searchTerm = substr($key, strlen('__quick_add__'));

                            $newRecord = $model::create([
                                $titleAttribute => $searchTerm,
                            ]);

                            $newState[] = $newRecord->getKey();
                            $created = true;
                        } else {
                            $newState[] = $key;
                        }
                    }

                    if ($created) {
                        $component->state($newState);
                    }
                } elseif (is_string($state) && str_starts_with($state, '__quick_add__')) {
                    // Handle single select
                    $searchTerm = substr($state, strlen('__quick_add__'));

                    $newRecord = $model::create([
                        $titleAttribute => $searchTerm,
                    ]);

                    $component->state($newRecord->getKey());
                    $component->refreshSelectedOptionLabel();
                    $created = true;
                }

                if ($created) {
                    $component->getLivewire()->dispatch(
                        'quick-add-created',
                        statePath: $component->getStatePath(),
                        resetSearch: $resetSearch,
                    );
                }
            });

            // Override getOptionLabelsUsing to ensure proper labels for created records
            $this->getOptionLabelsUsing(function (Select $component, array $values) {
                $relationship = $component->getRelationship();
                if (! $relationship) {
                    return [];
                }

                $titleAttribute = $component->getRelationshipTitleAttribute();
                $model = $relationship->getRelated();
                $keyName = $model->getKeyName();

                return $model::query()
                    ->whereIn($keyName, $values)
                    ->pluck($titleAttribute, $keyName)
                    ->toArray();
            });

            return $this;
        });
    }
}
