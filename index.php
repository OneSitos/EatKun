<?php
$accept_language = '';
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
}

$language_rules = array(
    array('regex' => '/^zh-TW\b/i', 'lang' => 'zht'),
    array('regex' => '/^zh-HK\b/i', 'lang' => 'zht'),
    array('regex' => '/^zh-MO\b/i', 'lang' => 'zht'),
    array('regex' => '/^zh-Hans\b/i', 'lang' => 'zh'),
    array('regex' => '/^zh-Hant\b/i', 'lang' => 'zht'),
    array('regex' => '/^zh\b/i', 'lang' => 'zh'),
    array('regex' => '/^ja\b/i', 'lang' => 'ja'),
    array('regex' => '/.*/', 'lang' => 'en')
);

$lang_code = 'en';

if (!empty($accept_language)) {
    $langs = explode(',', $accept_language);
    $primary_lang = trim($langs[0]);
    $primary_lang = preg_replace('/;q=[0-9.]+$/', '', $primary_lang);
    
    foreach ($language_rules as $rule) {
        if (preg_match($rule['regex'], $primary_lang)) {
            $lang_code = $rule['lang'];
            break;
        }
    }
}

$lang_file = "static/i18n/" . $lang_code . ".json";

if (!file_exists($lang_file)) {
    $lang_file = "static/i18n/en.json";
}

$lang_data = file_get_contents($lang_file);
if ($lang_data === FALSE) {
    $lang_data = '{}';
}

$i18n = json_decode($lang_data, true);
if ($i18n === NULL) {
    $i18n = array();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title data-i18n="eat-kun">EatKun</title>
    <meta itemprop="name" content="EatKun" />
    <meta itemprop="description" content="New concept audio game" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0, width=device-width,target-densitydpi=device-dpi" />
    <link rel="icon" href="./static/image/ProgressiveWebApps.png" type="image/x-icon" />
    <link rel="apple-touch-icon" id="applogo" href="./static/image/ProgressiveWebApps.png">
    <link href="./static/index.css" rel="stylesheet" type="text/css">
    <script src="./files/js/soundjs.min.js"></script>
    <script src="./files/js/flashaudioplugin.min.js"></script>
    <script src="./files/js/jsencrypt.min.js"></script>
    <link href="./files/css/bootstrap.min.css" rel="stylesheet">
    <script src="./files/js/bootstrap.bundle.min.js"></script>
    <script src="./files/js/jquery.min.js"></script>
    <script src="https://pv.sohu.com/cityjson?ie=utf-8"></script>
	<?php
    session_start();
    $str = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890'), 0, 8);
    $_SESSION['t'] = $str;
    echo "<script>var tj='" . $str . "'</script>";
    ?>
</head>

<body onLoad="init()" oncontextmenu=self.event.returnValue=false>
    <div id="GameScoreLayer" class="BBOX SHADE bgc1 default-mouse" style="display:none;">
        <div style="padding:5%;margin-top: 200px;background-color: rgba(125, 181, 216, 0.3);">
                <div id="GameScoreLayer-text"></div>
                <div id="GameScoreLayer-CPS" class="mb-2 d-flex flex-row justify-content-center text-start">
                    <div class="col-3" data-i18n="cps">CPS-I18N</div>
                    <div class="col-2" id="cps"></div>
                </div>
                <div id="GameScoreLayer-score" class="mb-2 d-flex flex-row justify-content-center text-start">
                    <div class="col-3" data-i18n="score">SCORE-I18N</div>
                    <div class="col-2" id="score"></div>
                </div>
                <div id="GameScoreLayer-bast" class="mb-2 d-flex flex-row justify-content-center text-start">
                    <div class="col-3" data-i18n="best">BEST-I18N</div>
                    <div class="col-2" id="best"></div>
                </div>
                <button type="button" class="btn btn-secondary btn-lg" id="replay" onclick="replayBtn()" data-i18n="again">AGAIN-I18N</button>
                <button type="button" class="btn btn-secondary btn-lg" onclick="backBtn()" data-i18n="home">HOME-I18N</button>
                <button type="button" class="btn btn-secondary btn-lg" onclick="goRank()" data-i18n="rank">RANK-I18N</button>
                <button type="button" class="btn btn-secondary btn-lg" onclick="openWebpage('https://github.com/OneSitos/EatKun')" data-i18n="repo">REPO-I18N</button>
                <button type="button" class="btn btn-secondary btn-lg" onclick="openWebpage('https://github.com/OneSitos/EatKun/wiki#license')" data-i18n="license">LICENSE-I18N</button>
                <button type="button" class="btn btn-secondary btn-lg" onclick="openWebpage('https://github.com/OneSitos/EatKun/blob/main/README_EN.md#used-items-and-their-licenses')" data-i18n="use-project">USE-PROJECT-I18N</button>
                <button type="button" class="btn btn-secondary btn-lg" onclick="openWebpage('https://github.com/OneSitos/EatKun/wiki#disclaimer')" data-i18n="disclaimer">DISCLAIMER-I18N</button>
            </div>
    </div>
    <div id="welcome" class="SHADE BOX-M">
        <div class="welcome-bg FILL"></div>
        <div class="FILL BOX-M" style="position:absolute;top:0;left:0;right:0;bottom:0;z-index:5;">
            <div class="container">
                <div class="container mb-5 default-mouse">
                    <div style="font-size:2.6em; color:#FEF002;" data-i18n="game-title"><?php echo $i18n['enable-javascript']; ?></div><br />
                    <div id="desc" style="display: block;font-size:2.2em; color:#fff; line-height:1.5em;">
                        <span data-i18n="game-intro1">GAME-INTRO1-I18N</span><br />
                        <span data-i18n="game-intro2">GAME-INTRO2-I18N</span><br />
                        <span data-i18n="game-intro3">GAME-INTRO3-I18N</span><br />
                        <span data-i18n="game-intro4">GAME-INTRO4-I18N</span><br />
                    </div>
                    <div id="version" style="display: none;font-size:2.2em; color:#fff; line-height:1.5em;">
                        <span data-i18n="version">VERSION-I18N</span><a href="javascript: void(0);" onclick="openWebpage('https://github.com/OneSitos/EatKun/tree/0.2.2')">0.2.2</a><br />
                    </div>
                </div>
                <div id="btn_group" class="container text-nowrap">
                    <div class="d-flex justify-content-center flex-column flex-fill">
                        <a class="btn btn-primary btn-lg mb-3" onclick="readyBtn()" data-i18n="start">START-I18N</a>
                        <div class="dropdown mb-3">
                            <a class="w-100 btn btn-secondary btn-lg" href="javascript: void(0);" role="button" id="mode" data-bs-toggle="dropdown" aria-expanded="false"data-i18n="mode">MODE-I18N</a>
                            <ul class="dropdown-menu" aria-labelledby="mode">
                                <li><a class="dropdown-item" onclick="changeMode(MODE_NORMAL)" data-i18n="normal">NORMAL-I18N</a></li>
                                <li><a class="dropdown-item" onclick="changeMode(MODE_ENDLESS)" data-i18n="endless">ENDLESS-I18N</a></li>
                                <li><a class="dropdown-item" onclick="changeMode(MODE_PRACTICE)" data-i18n="practice">PRACTICE-I18N</a></li>
                            </ul>
                        </div>
                        <a class="btn btn-secondary btn-lg" onclick="show_setting()" data-i18n="settings">SETTINGS-I18N</a>
                    </div>
                </div>
                <div id="setting" class="container default-mouse" style="display: none;">
                    <div class="container mb-3 btn-group">
                        <a data-i18n="img-before" type="button" class="btn text-nowrap btn-secondary me-1" onclick="getClickBeforeImage()" style="left: 0">IMG-BEFORE-I18N</a>
                        <input type="file" id="click-before-image" accept="image/*" class="d-none" onchange="saveClickBeforeImage()">
                        <a data-i18n="img-after" type="button" class="btn text-nowrap btn-secondary me-1" onclick="getClickAfterImage()" style="right: 0">IMG-AFTER-I18N</a>
                        <input type="file" id="click-after-image" accept="image/*" class="d-none" onchange="saveClickAfterImage()">
                        <div class="input-group-prepend">
                            <span class="input-group-text" data-i18n="sound">SOUND-I18N</span>
                        </div>
                        <input type="checkbox" class="checkbox-input form-check form-check-input" id="sound" onclick="changeSoundMode()">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend col-2">
                            <span class="input-group-text" data-i18n="title">TITLE-I18N</span>
                        </div>
                        <input data-placeholder-i18n="eat-kun" type="text" id="title" class="form-control" placeholder="EAT-KUN-I18N">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend col-2">
                            <span data-i18n="key" class="input-group-text">KEY-I18N</span>
                        </div>
                        <input data-placeholder-i18n="default-dfjk" type="text" id="keyboard" class="form-control" maxlength=4 placeholder="DFJK-I18N">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend col-2">
                            <span data-i18n="time" class="input-group-text">TIME-I18N</span>
                        </div>
                        <input data-placeholder-i18n="default-20s" type="text" id="gameTime" class="form-control" maxlength=4 placeholder="default-20s">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend col-2">
                            <span class="input-group-text" data-i18n="name">NAME-I18N</span>
                        </div>
                        <input data-placeholder-i18n="record-rank" type="text" id="username" class="form-control" maxlength=8 placeholder="RECORD-RANK-I18N">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend col-2">
                            <span class="input-group-text" data-i18n="comment">COMMENT-I18N</span>
                        </div>
                        <input data-placeholder-i18n="no-ad-bad-lang" type="text" id="message" class="form-control" maxlength=50 placeholder="NO-AD-BAD-LANG-I18N">
                    </div>
                    <button type="button" class="btn btn-secondary btn-lg" onclick="show_btn();save_cookie();" data-i18n="ok">OK-I18N</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./static/index.js"></script>
</body>

</html>