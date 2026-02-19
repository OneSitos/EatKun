<p align="center">
  <a href="https://chicxk.pages.dev/"><img src="static/image/ClickBefore.png" width="100" height="100" alt="吃掉蔡徐坤"></a>
</p>
<div align="center">

# 吃掉蔡徐坤

_🦌 網頁小遊戲 🥛_

</div>


## 簡介

小遊戲：吃掉蔡徐坤

最新版本號：[0.0.4](https://github.com/OneSitos/EatKun/tree/0.0.4)

[English](README_EN.md)
|
[简体中文](README.md)
|
[Github](https://github.com/EatKun)
|
[Wiki](https://github.com/OneSitos/EatKun/wiki)
|
[遊玩](https://chicxk.pages.dev/)
|
[最新 Build](https://OneSitos.github.io/EatKun/index.html)
|
[Releases](https://github.com/OneSitos/EatKun/releases)

## 可選功能

簡易排行榜（日/週/月）不建議使用。

不需要排行榜把 php/sql 文件都刪掉即可。

## 版本需求

+ MySQL 5+
+ PHP 5+

## 免責聲明

本遊戲與蔡徐坤本人及其經紀團隊無任何關聯，僅供娛樂。

`static/image`、`static/music`內容來自[爱给网](https://www.aigei.com/s?q=%E8%94%A1%E5%BE%90%E5%9D%A4&type=sound)，若侵權可在 [Issues](https://github.com/OneSitos/EatKun/issues) 聯繫刪除，並附上`delete`標籤。

## 使用方法

註: 如果你想玩的話直接[去玩](https://chicxk.pages.dev/)就可以，這裡是如何創建你的改版。

### Github Pages

點[這裡](https://www.bilibili.com/video/BV1r94y1d765)看視頻步驟。

如果你不需要排行榜，那麼部署到 Github Pages 即可。

按照如下方法更改你想要顯示的文字。

1. **Fork本專案，不要在現在這個頁面直接修改，然後發現改不了。**

2. **打開你Fork的專案**，找到`static/i18n/zht.json`，找到下面這幾項配置：

   ```json
   {
     "game-title": "新概念音遊",
     "game-intro1": "從最底下的開始",
     "game-intro2": "看你能得多少分",
     "game-intro3": "OK!",
     "game-intro4": "蔡徐坤一個不留！",
     "text-level-1": "試著好好練個兩年半?",
     "text-level-2": "還沒到蔡徐坤的程度!",
     "text-level-3": "馬上就要超過蔡徐坤的程度!",
     "text-level-4": "你應該已經練了兩年半了吧!",
     "text-level-5": "蔡徐坤：又有一位IKUN加入我們的荔枝集團了!"
   }
   ```

你可以隨意更改右側文字，就可以顯示你想要的內容，**不要刪掉雙引號**！

3. 找到`static/image`資料夾，點擊前顯示的圖片是`ClickBefore.png`，點擊後的圖片是`ClickAfter.png`，把它們改成你想要的即可。

   **注意檔案格式，需要是png**

4. 找到`static/music`資料夾，點擊時的音效是`tap.mp3`，正常結束的音效是`end.mp3`，點擊錯誤的音效是`err.mp3`，把它們改成你想要的即可。

   **注意檔案格式，需要是mp3**

5. 更改完畢後前往專案的`Settings` -> `Pages` -> `Source`，選擇`main` 分支然後點擊`Save`。

### 部署到伺服器

按照這些步驟來在你的伺服器上配置排行榜的資料庫。

1. 創建資料庫並且執行提供的腳本（這裡用`kun`作為資料庫名）：

   ```sql
   CREATE DATABASE kun DEFAULT CHARSET=utf8;
   USE kun;
   SOURCE kun.sql;
   ```

2. 更改有資料庫資訊的`conn.php`為你的資料庫配置：

   ```php
   <?php
   // 把這裡改為你的配置
   $link = new mysqli('localhost','NAME','PASSWORD','kun');
   mysqli_set_charset($link, 'utf8');
   if ($link->connect_error) {
       die("Failed to connect: " . $conn->connect_error);
   }
   $ranking = "kun_rank";
   ```

## 使用的項目及其許可證

1. EatKano ([網站](https://xingye.me/game/eatkano) [GitHub](https://github.com/arcxingye/EatKano) [許可證：MIT license](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.arcxingye.EatKano_LICENSE.txt))

2. EatCat ([GitHub](https://github.com/122440367/eatcat) 許可證：未知)

3. EatCat ([GitHub](https://github.com/Webpage-gh/eatcat) [許可證：Apache License 2.0](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.Webpage-gh.eatcat_LICENSE.txt))

4. Bootstrap v5.1.1 ([網站](https://getbootstrap.com/) [GitHub](https://github.com/twbs/bootstrap/releases/tag/v5.1.1) [許可證：MIT license](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.twbs.bootstrap_LICENSE.txt))

5. CREATEJS v1.0.0 ([網站](http://createjs.com/) [GitHub](https://github.com/CreateJS/CreateJS) [許可證：MIT license](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.CreateJS.CreateJS_LICENSE.txt))

6. jQuery 3.6.0 ([網站](https://jquery.com/) [GitHub](https://github.com/jquery/jquery/releases/tag/3.6.0) [許可證](https://raw.githubusercontent.com/EatKun/EatKun/refs/heads/main/files/license/github.jquery.jquery_LICENSE.txt)) 

7. JSEncrypt ([網站](https://travistidwell.com/jsencrypt) [GitHub](https://github.com/travist/jsencrypt) [許可證](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.travist.jsencrypt_LICENSE.txt))

## Star 統計

[![Stargazers over time](https://starchart.cc/OneSitos/EatKun.svg?variant=adaptive)](https://starchart.cc/OneSitos/EatKun)

## 其它事項

本項目使用 **[MIT License](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/LICENSE-code)** 進行授權，在使用本項目時，請標註來源/原作者。

`README.md`、`README_EN.md`和本項目 [Wiki](https://github.com/OneSitos/EatKun/wiki) **使用 [Creative Commons Attribution 4.0 International Public License](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/LICENSE-text)** 進行授權，在使用這些文本時，請標註來源。