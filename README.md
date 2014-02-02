# 売りたい書籍のCSVファイル作成 for 電脳書房

[電脳書房](http://www.bookcyber.net/)では売りたい書籍のリストをCSVファイルで送り事前見積りをしてもらうのが、電脳書房が[おすすめする買取方法](http://www.bookcyber.net/kaitori.htm)となっています。

そのためのCSVファイルを作成するためのWebアプリです。

[国立国会図書館サーチのAPI](http://iss.ndl.go.jp/information/api/)を使っています。

## 要件

* PHP 5.3以上（5.4以上を推奨）
* [Git](http://git-scm.com/)コマンド（インストールに必要）

## インストール方法

~~~
$ git clone https://github.com/kenjis/csv-maker-for-bookcyber.git
$ cd csv-maker-for-bookcyber
$ php composer.phar install
~~~

## 実行方法

publicフォルダをWebサーバからアクセス可能に設定し、ブラウザでアクセスしてください。

PHP 5.4以上では、以下のコマンドを実行し、http://localhost:8000 にアクセスしてください。

~~~
$ php oil server
~~~

## 開発

最低限の機能しかありません。書籍の状態は記入できませんのでダウンロードしたCSVを表計算ソフトで加工してください。ページのデザインもひどいです。テストもありません。ソースを見て直したくなった人はPull Requestしてください。

## ライセンス

MITライセンスです。LICENSEファイルを参照してください。なお、含まれるライブラリなどのライセンスは、それらのライセンスに従ってください。
