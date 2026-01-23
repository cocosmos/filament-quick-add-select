# Changelog

All notable changes to `filament-quick-add-select` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.3] - 2026-01-23

### Fixed
- Fixed translation loading - changed `__('quick-add.add')` to `__('quick-add::quick-add.add')` to use package namespace
- Translations now properly display in all 6 supported languages instead of showing raw key

## [1.0.2] - 2026-01-23

### Fixed
- **CRITICAL:** Added missing namespace declaration in FilamentQuickAddServiceProvider
- Added translation file loading and publishing to service provider
- Package now properly auto-discovers and loads without errors

## [1.0.1] - 2026-01-23

### Fixed
- Added Laravel 12 support to composer.json requirements
- Updated `illuminate/contracts` constraint to support both Laravel 11 and 12 (`^11.0 || ^12.0`)
- Updated `orchestra/testbench` to support Laravel 12 testing (`^9.0 || ^10.0`)

## [1.0.0] - 2026-01-23

### Added
- Initial release
- Quick add functionality for Filament Select components with relationships
- Support for single and multiple select fields
- Instant record creation without modal interruption
- Multi-language support with 6 languages (EN, FR, DE, ES, IT, PT)
- Customizable "Add" button label
- Dark mode compatibility
- Automatic label fetching after record creation
- Documentation with usage examples and screenshots

### Features
- `->quickAdd()` method for Select components
- Custom label support via closure or string template
- Conditional enabling/disabling of quick add feature
- Works seamlessly with Livewire's reactive updates

[Unreleased]: https://github.com/cocosmos/filament-quick-add-select/compare/v1.0.3...HEAD
[1.0.3]: https://github.com/cocosmos/filament-quick-add-select/compare/v1.0.2...v1.0.3
[1.0.2]: https://github.com/cocosmos/filament-quick-add-select/compare/v1.0.1...v1.0.2
[1.0.1]: https://github.com/cocosmos/filament-quick-add-select/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/cocosmos/filament-quick-add-select/releases/tag/v1.0.0
