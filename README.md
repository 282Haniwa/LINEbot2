# LINEbot第2作目
## 作るに至った経緯
このボットはLINEbotを作るということとクラス設計の勉強、様々なAPIを触ることを目的として作った。

## 使ったAPI
Google Cloud Vision API  
LINE bot API

## 注意
このPHPのコードは無料試用を前提に書かれているのでGoogle Cloud VisionのAPIの有料サービスを利用する場合一部書き換える必要があるかもしれない(request uri 等)

## 機能説明
### 機能１
このBotにテキストを投げるとその内容に草を生やして返す。

### 機能２
このBotに文字の含まれる画像を投げると画像内の文字を返してくれる。(Google Cloud Vision API)  
