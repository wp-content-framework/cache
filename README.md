# WP Content Framework (Cache module)

[![CI Status](https://github.com/wp-content-framework/cache/workflows/CI/badge.svg)](https://github.com/wp-content-framework/cache/actions)
[![License: GPL v2+](https://img.shields.io/badge/License-GPL%20v2%2B-blue.svg)](http://www.gnu.org/licenses/gpl-2.0.html)
[![PHP: >=5.6](https://img.shields.io/badge/PHP-%3E%3D5.6-orange.svg)](http://php.net/)
[![WordPress: >=3.9.3](https://img.shields.io/badge/WordPress-%3E%3D3.9.3-brightgreen.svg)](https://wordpress.org/)

[WP Content Framework](https://github.com/wp-content-framework/core) のモジュールです。

# 要件
- PHP 5.6 以上
- WordPress 3.9.3 以上

# インストール

``` composer require wp-content-framework/cache ```

## 関連モジュール
* [cron](https://github.com/wp-content-framework/cron)
  * 期限切れのキャッシュを定期的に削除する場合はインストールが必要です。

## 基本設定
- configs/config.php

|設定値|説明|
|---|---|
|cache_type|キャッシュタイプ(settingよりも優先, defaultはなし)|
|delete_cache_group|削除を行うグループ|
|delete_cache_common_group|削除を行うグループ(共通用)|

- configs/settings.php

|設定値|説明|
|---|---|
|cache_type|キャッシュタイプ(option or file) \[default = option]|
|delete_cache_interval|キャッシュ削除間隔を設定 \[default = 86400]|

# Author

[GitHub (Technote)](https://github.com/technote-space)
[Blog](https://technote.space)
