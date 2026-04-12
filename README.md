<p align="center">
  <a href="https://chicxk.pages.dev/"><img src="static/image/ProgressiveWebApps.png" width="100" height="100" alt="吃掉蔡徐坤"></a>
</p>
<div align="center">

# 吃掉蔡徐坤

_🦌 网页小游戏 🥛_

</div>


## 简介

小游戏：吃掉蔡徐坤

最新版本号：[0.2.2](https://github.com/OneSitos/EatKun/tree/0.2.2)

[English](README_EN.md)
|
[繁體中文](README_HANT.md)
|
[Github](https://github.com/EatKun)
|
[Wiki](https://github.com/OneSitos/EatKun/wiki)
|
[游玩](https://chicxk.pages.dev/)
|
[最新 Build](https://OneSitos.github.io/EatKun/index.html)
|
[Releases](https://github.com/OneSitos/EatKun/releases)

## 可选功能

简易排行榜（日/周/月）不推荐使用。

不需要排行榜把 `php/sql` 文件都删掉即可。

## 版本需求

### 后端

启用排行榜时需要以下环境支持：

+ [MySQL](https://dev.mysql.com/downloads/mysql/) 5.5.3+
+ [PHP](https://www.php.net/downloads.php) 5.3.0+

并为 PHP 安装额外扩展：

+ MySQLi
+ OpenSSL

### 前端

#### PC 端

+ [Chrome](https://www.google.com/chrome/) 60+
+ [Edge](https://www.microsoft.com/edge/) 12+ / 79+
+ [Firefox](https://www.firefox.com/) 60+
+ [Safari](https://www.apple.com/safari/) 12+

#### 移动端

+ [Chrome Android](https://play.google.com/store/apps/details?id=com.android.chrome) 60+
+ [Firefox for Android](https://play.google.com/store/apps/details?id=org.mozilla.firefox) 60+
+ [Safari](https://www.apple.com/safari/) on iOS 12+
+ [WebView Android](https://play.google.com/store/apps/details?id=com.google.android.webview) API26+
+ [WebView on iOS](https://developer.apple.com/documentation/webkit/wkwebview) 12+

## 免责声明

本游戏与蔡徐坤本人及其经纪团队无任何关联，仅供娱乐。

`static/image`、`static/music`内容来自[爱给网](https://www.aigei.com/s?q=%E8%94%A1%E5%BE%90%E5%9D%A4&type=sound)，若侵权可在 [Issues](https://github.com/OneSitos/EatKun/issues) 联系删除，并附上`delete`标签。

## 使用方法

注: 如果你想玩的话直接[去玩](https://chicxk.pages.dev/)就可以，这里是如何创建你的改版。

### Github Pages

点[这里](https://www.bilibili.com/video/BV1r94y1d765)看视频步骤。

如果你不需要排行榜，那么部署到 Github Pages 即可。

按照如下方法更改你想要显示的文字。

1. **Fork本项目，不要在现在这个页面直接改，然后发现改不了。**

2. **打开你Fork的项目**，找到`static/i18n/zh.json`，找到下面这几项配置：

   ```json
   {
     "game-title": "新概念音游",
     "game-intro1": "从最底下的开始",
     "game-intro2": "看你能得多少分",
     "game-intro3": "OK!",
     "game-intro4": "蔡徐坤一个不留！",
     "text-level-1": "试着好好练个两年半?",
     "text-level-2": "还没到蔡徐坤的程度!",
     "text-level-3": "马上就要超过蔡徐坤的程度!",
     "text-level-4": "你应该已经练了两年半了吧!",
     "text-level-5": "蔡徐坤:又有一位IKUN加入我们的荔枝集团了!"
   }
   ```

   你可以随意更改右侧文字，就可以显示你想要的内容，**不要删掉双引号**！

3. 找到`static/image`文件夹，点击前显示的图片是`ClickBefore.png`, 点击后的图片是`ClickAfter.png`，网站显示的图标为`ProgressiveWebApps.png`（比例必须为 1:1），把他们改成你想要的即可。

   **注意文件格式，需要是 `png`。**

4. 找到`static/music`文件夹，点击时的音效是`tap.mp3`，正常结束的音效是`end.mp3`，点击错误的音效是`err.mp3`，把他们改成你想要的即可。

   **注意文件格式，需要是 `mp3`。**

5. 更改完毕后前往项目的`Settings` -> `Pages` -> `Source`，选择`main` 分支然后点击`Save`。

### 部署到服务器

按照这些步骤来在你的服务器上配置排行榜的数据库。

1. 创建数据库并且执行提供的脚本（这里用`kun`作为数据库名）：

   ```sql
   CREATE DATABASE kun DEFAULT CHARSET=utf8mb4;
   USE kun;
   SOURCE kun.sql;
   ```

2. 更改有数据库信息的`conn.php`为你的数据库配置：

   ```php
   <?php
   // 把这里改为你的配置
   $link = new mysqli('localhost','NAME','PASSWORD','kun');
   mysqli_set_charset($link, 'utf8mb4');
   if ($link->connect_error) {
       die("Failed to connect: " . $conn->connect_error);
   }
   $ranking = "kun_rank";
   ```

3. （如果需要在生产环境中应用）更改有私钥的`SubmitResults.php`为你生成的私钥：

   ```php
   <?php
   ...
   // 把这里改为你的配置
   $encryptString = file_get_contents("php://input");
   $decrypted = '';
   $key       = "你的私钥";
   $key_eol   = (string) implode("\n", str_split((string) $key, 64));
   $privateKey = (string) "-----BEGIN PRIVATE KEY-----\n" . $key_eol . "\n-----END PRIVATE KEY-----";
   @openssl_private_decrypt(base64_decode($encryptString), $decrypted, $privateKey);
   $arr = explode('|_|', $decrypted);
   ...
   ```

4. （如果需要在生产环境中应用）更改有公钥的`index.js`为你生成的公钥：

   ```js
   ...
   // 把这里改为你的配置
   function encrypt(text) {
       let encrypt = new JSEncrypt();
       encrypt.setPublicKey("你的公钥");
       return encrypt.encrypt(text);
   }
   ...
   ```

## 使用的项目及其许可证

1. EatKano ([网站](https://xingye.me/game/eatkano) [GitHub](https://github.com/arcxingye/EatKano) [许可证：MIT license](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.arcxingye.EatKano_LICENSE.txt))

2. EatCat ([GitHub](https://github.com/122440367/eatcat) 许可证：未知)

3. EatCat ([GitHub](https://github.com/Webpage-gh/eatcat) [许可证：Apache License 2.0](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.Webpage-gh.eatcat_LICENSE.txt))

4. Bootstrap 5.1.3 ([网站](https://getbootstrap.com/) [GitHub](https://github.com/twbs/bootstrap/releases/tag/v5.1.3) [许可证：MIT license](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.twbs.bootstrap_LICENSE.txt))

5. SoundJS 1.0.2 ([网站](https://createjs.com/soundjs) [GitHub](https://github.com/CreateJS/SoundJS) [许可证：MIT license](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.CreateJS.SoundJS_LICENSE.txt))

6. jQuery 3.7.1 ([网站](https://jquery.com/) [GitHub](https://github.com/jquery/jquery/releases/tag/3.7.1) [许可证](https://raw.githubusercontent.com/EatKun/EatKun/refs/heads/main/files/license/github.jquery.jquery_LICENSE.txt))

7. JSEncrypt 3.5.4 ([网站](https://travistidwell.com/jsencrypt) [GitHub](https://github.com/travist/jsencrypt/releases/tag/v3.5.4) [许可证](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.travist.jsencrypt_LICENSE.txt))

## Star 统计

[![Stargazers over time](https://starchart.cc/OneSitos/EatKun.svg?variant=adaptive)](https://starchart.cc/OneSitos/EatKun)

## 其它事项

本项目使用 **[MIT License](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/LICENSE-code)** 进行授权，在使用本项目时，请标注来源/原作者。

`README.md`、`README_EN.md`和本项目 [Wiki](https://github.com/OneSitos/EatKun/wiki) **使用 [Creative Commons Attribution 4.0 International Public License](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/LICENSE-text)** 进行授权，在使用这些文本时，请标注来源。