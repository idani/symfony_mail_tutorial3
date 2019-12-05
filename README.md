# symfony_mailer_tutorial3

# 必要なもの

* docker
* docker-compose

私は、Windows10 proの環境で動作確認をしています。

# Docker環境構築

`docker-compose build`

# Docker環境起動

`docker-compose up -d`

# 終了

`docker-compose down`

# 開発時

PHPの実行環境にBashを入れていますので、以下のコマンドで入って操作ができます。

`docker-compose exec php /bin/bash`

## アプリ

スケルトンのトップ画面

http://localhost:8000/

メール送信画面。表示するとすぐに送信しちゃいます。

http://localhost:8000/mailer

MailDev

http://localhost:8025/
