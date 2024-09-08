# Changelog

## [2.1.0](https://github.com/Lendable/message/compare/2.0.1...2.1.0) (2024-09-08)


### Features

* Add class-map based message name resolvers ([#139](https://github.com/Lendable/message/issues/139)) ([01fac65](https://github.com/Lendable/message/commit/01fac65207d25473922fc519e7ae5f1f2b494076))


### Fixes

* Export-ignore `.allowed-licenses.php` ([#140](https://github.com/Lendable/message/issues/140)) ([763c157](https://github.com/Lendable/message/commit/763c1571523229c63a79aea8a51a2a516b277dbc))

## [2.0.1](https://github.com/Lendable/message/compare/2.0.0...2.0.1) (2024-06-12)


### Fixes

* Document `QueryNameResolver` throws `QueryNameNotResolvable` ([#102](https://github.com/Lendable/message/issues/102)) ([76c5067](https://github.com/Lendable/message/commit/76c50677dad8cadcd5638257461afd05d3de49e9))

## [2.0.0](https://github.com/Lendable/message/compare/1.0.4...2.0.0) (2024-06-02)


### ⚠ BREAKING CHANGES

* concrete exception type for `MetadataSerializer` deserialization failure ([#63](https://github.com/Lendable/message/issues/63))

### Features

* Concrete exception type for `MetadataSerializer` deserialization failure ([#63](https://github.com/Lendable/message/issues/63)) ([dfca5cd](https://github.com/Lendable/message/commit/dfca5cd072d874f99c7d229ac9979c9a313712a6))

## [1.0.4](https://github.com/Lendable/message/compare/1.0.3...1.0.4) (2024-06-02)


### Fixes

* Add `phpstan-assert` for `non-empty-string` to `MessageId` factories for call site inference ([#90](https://github.com/Lendable/message/issues/90)) ([e433b36](https://github.com/Lendable/message/commit/e433b36926e5ad6b5e0acfabe6e446f278faa92e))
* Add `phpstan-assert` for `non-empty-string` to `UuidConverter` for call site inference ([#91](https://github.com/Lendable/message/issues/91)) ([664ab9c](https://github.com/Lendable/message/commit/664ab9c55fcf7f1ced24d2c3afcc654fd8858e64))

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
