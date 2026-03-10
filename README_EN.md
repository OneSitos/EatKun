<p align="center">
  <a href="https://chicxk.pages.dev/"><img src="static/image/ProgressiveWebApps.png" width="100" height="100" alt="EatKun"></a>
</p>
<div align="center">

# EatKun

_🦌 Web Game 🥛_

</div>


## Introduction

A web game: EatKun

Latest version: [0.1.0](https://github.com/OneSitos/EatKun/tree/0.1.0)

[简体中文](README.md)
|
[繁體中文](README_HANT.md)
|
[Github](https://github.com/EatKun)
|
[Wiki](https://github.com/OneSitos/EatKun/wiki)
|
[Play](https://chicxk.pages.dev/)
|
[Latest Build](https://OneSitos.github.io/EatKun/index.html)
|
[Releases](https://github.com/OneSitos/EatKun/releases)

## Features

A simple ranking list (day/week/month) is provided.

You can delete all the sql/php files if you don't need them.

## Requirements

+ MySQL 5+
+ PHP 5+

## Disclaimer

This game has no association with 蔡徐坤 or his management team and is for entertainment purposes only.

The content of `static/image` and `static/music` comes from the [爱给网](https://www.aigei.com/s?q=%E8%94%A1%E5%BE%90%E5%9D%A4&type=sound). If there is infringement, it can be found in [Issues](https://github.com/OneSitos/EatKun/issues) Contact to delete and attach the 'delete' tag.

## Usage

Note: if you just want to play it, go to [online version](https://chicxk.pages.dev/). Here is how to create your own version.

### Github Pages

You can run it on Github Pages if you don't need the ranking list.

Follow these steps to change the text displayed to what you want.

1. **Fork this repository. DON'T CHANGE DIRECTLY IN THIS PROJECT.**

2. **Open the repo you forked.** Go to `static/i18n/en.json` and find these texts below:

   ```json
   {
     "game-title": "New concept audio game",
     "game-intro1": "Start at the bottom and",
     "game-intro2": "see how many points you can get",
     "game-intro3": "OK!",
     "game-intro4": "KUN does not leave one! ",
     "text-level-1": "Try to practice well for two and a half years?",
     "text-level-2": "Not yet to the level of KUN!",
     "text-level-3": "Soon to surpass KUN!",
     "text-level-4": "You should have been practicing for 2.5 years!",
     "text-level-5": "KUN: Another love KUN has joined our Litchi Group!",
   }
   ```

   You can change the text on the right side. **Note that don't remove quotes(i.e. `"`)**

3. Go to directory `static/image`. The image shown before clicking is `ClickBefore.png`, after is `ClickAfter.png`, and the icon displayed on the website is `ProgressiveWebApps.png`.

   **The file type must be png**

4. Go to directory `static/music`. The sound played when tapping is `tap.mp3`, when ending without errors is `end.mp3`, while ending with errors is `err.mp3`.

   **The file type must be mp3**

5. After changing all resources to your own, go to repository `Settings` -> `Pages` -> `Source`, choose `main` branch and click `Save`.

### Deploying to Server

Follow these few steps to configure the database for ranking list on your server.

1. Create your own database and execute the script provided(e.g. use `kun` as database name):

   ```sql
   CREATE DATABASE kun DEFAULT CHARSET=utf8;
   USE kun;
   SOURCE kun.sql;
   ```

2. Change the code in `conn.php`, which contains your database info, and its content is here:

   ```php
   <?php
   // Change this to your own configuration
   $link = new mysqli('localhost','NAME','PASSWORD','kun');
   mysqli_set_charset($link, 'utf8');
   if ($link->connect_error) {
       die("Failed to connect: " . $conn->connect_error);
   }
   $ranking = "kun_rank";
   ```

## Used items and their licenses

1. EatKano ([Website](https://xingye.me/game/eatkano) [GitHub](https://github.com/arcxingye/EatKano) [License: MIT license](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.arcxingye.EatKano_LICENSE.txt))

2. EatCat ([GitHub](https://github.com/122440367/eatcat) License: Unknown)

3. EatCat ([GitHub](https://github.com/Webpage-gh/eatcat) [License: Apache License 2.0](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.Webpage-gh.eatcat_LICENSE.txt))

4. Bootstrap v5.1.1 ([Website](https://getbootstrap.com/) [GitHub](https://github.com/twbs/bootstrap/releases/tag/v5.1.1) [License: MIT license](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.twbs.bootstrap_LICENSE.txt))

5. CREATEJS v1.0.0 ([Website](http://createjs.com/) [GitHub](https://github.com/CreateJS/CreateJS) [License: MIT license](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.CreateJS.CreateJS_LICENSE.txt))

6. jQuery 3.6.0 ([Website](https://jquery.com/) [GitHub](https://github.com/jquery/jquery/releases/tag/3.6.0) [License](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.jquery.jquery_LICENSE.txt))

7. JSEncrypt ([Website](https://travistidwell.com/jsencrypt) [GitHub](https://github.com/travist/jsencrypt) [License](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.travist.jsencrypt_LICENSE.txt))

## Star statistics

[![Stargazers over time](https://starchart.cc/OneSitos/EatKun.svg?variant=adaptive)](https://starchart.cc/OneSitos/EatKun)

## Others

This project is authorized by **[MIT License](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/LICENSE-code)**. When using this project, please indicate the source/original author.

`README.md` / `README_EN.md` and this [Wiki](https://github.com/OneSitos/EatKun/wiki) of this project are authorized to **use [Creative Commons Attribution 4.0 International Public License](https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/LICENSE-text)**. When using these texts, please indicate the source.