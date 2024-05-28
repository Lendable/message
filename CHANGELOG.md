# Changelog

## [1.0.3](https://github.com/Lendable/message/compare/1.0.2...1.0.3) (2024-05-28)


### Fixes

* Add `non-empty-string` inference for call site in `MessageName` ([#84](https://github.com/Lendable/message/issues/84)) ([ef94de3](https://github.com/Lendable/message/commit/ef94de32c2f74d525ff7454a3c762b758231397d))
* Document that `Metadata` withers only accept new additional metadata, not mandatory ([#79](https://github.com/Lendable/message/issues/79)) ([bb3c134](https://github.com/Lendable/message/commit/bb3c134b8552cae328a28d6d10b71abefadb1376))
* Validate inputs for `Metadata` to ensure serializable when ignoring static analysis types ([#77](https://github.com/Lendable/message/issues/77)) ([d9c2d67](https://github.com/Lendable/message/commit/d9c2d67013c6366ee0d6f48bd728f2fa70c4ff28))

## [1.0.2](https://github.com/Lendable/message/compare/1.0.1...1.0.2) (2024-05-08)


### Bug Fixes

* Document thrown exceptions in `Metadata` ([afb9efc](https://github.com/Lendable/message/commit/afb9efc11a632b4fef1b77dc7368bee2623a35cb))
* Document thrown exceptions in `UuidConverter` ([1e0ad78](https://github.com/Lendable/message/commit/1e0ad783b4559b09889a295eeced7be9072cd9bb))


### Performance Improvements

* Don't make new `MessageId` in `MetadataFactory` ([29bc606](https://github.com/Lendable/message/commit/29bc606c21f5c9048f2b686a279c1c5c0a93b2bd))
