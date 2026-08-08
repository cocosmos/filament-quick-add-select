# Security Policy

## Supported Versions

Security fixes are released for the latest minor release line. Older lines are not
patched — please upgrade before reporting an issue against them.

| Version | Supported          |
| ------- | ------------------ |
| 1.3.x   | :white_check_mark: |
| < 1.3   | :x:                |

## Reporting a Vulnerability

**Please do not report security vulnerabilities through public GitHub issues,
discussions, or pull requests.**

Report it privately in one of these ways:

- [Open a private security advisory](https://github.com/cocosmos/filament-quick-add-select/security/advisories/new)
  (preferred), or
- email **contact@mipam.ch** with the subject `SECURITY: filament-quick-add-select`.

Please include:

- a description of the vulnerability and its impact,
- the affected version(s) of this package, plus your PHP, Laravel, and Filament versions,
- steps to reproduce, or a proof-of-concept,
- any suggested mitigation you are aware of.

## What to Expect

- **Acknowledgement:** within 5 business days.
- **Assessment:** an initial severity assessment and remediation plan within 10 business days.
- **Fix:** patched in a new release as soon as a fix is validated; critical issues are
  prioritised over all other work.
- **Disclosure:** the advisory is published once a fixed release is available. You will be
  credited unless you ask to remain anonymous.

Please give us a reasonable opportunity to release a fix before disclosing the issue
publicly.

## Scope

This policy covers the code in this repository, published as the Composer package
`cocosmos/filament-quick-add-select`. Vulnerabilities in Filament, Laravel, or other
dependencies should be reported to their respective maintainers.
