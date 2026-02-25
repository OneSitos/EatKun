(function(w) {
    function getJsonI18N() {
        // 详见 https://developer.mozilla.org/zh-CN/docs/Web/API/Navigator/language

        const LANGUAGES = [
            { regex: /^zh-TW\b/i, lang: 'zht' },
            { regex: /^zh-HK\b/i, lang: 'zht' },
            { regex: /^zh-MO\b/i, lang: 'zht' },
            { regex: /^zh-Hans\b/i, lang: 'zh' },
            { regex: /^zh-Hant\b/i, lang: 'zht' },
            { regex: /^zh\b/i, lang: 'zh' },
            { regex: /^ja\b/i, lang: 'ja' },
            { regex: /.*/, lang: 'en'}
        ]

        const lang = LANGUAGES.find(l => l.regex.test(navigator.language)).lang

        const ERROR_MESSAGES = {
            'en': 'The language file error(s) was/were detected: ',
            'zh': '检测到语言文件错误：',
            'zht': '偵測到語言檔案錯誤：',
            'ja': '言語ファイルエラーが検出されました：'
        }

        const errorMsg = ERROR_MESSAGES[lang] || ERROR_MESSAGES['en']

        return $.ajax({
            url: `./static/i18n/${lang}.json`,
            dataType: 'json',
            method: 'GET',
            async: false,
            success: data => res = data,
            error: () => alert(errorMsg + lang)
        }).responseJSON
    }

    const I18N = getJsonI18N()

    $('[data-i18n]').each(function() {
        const content = I18N[this.dataset.i18n];
        $(this).text(content);
    });

    $('[data-placeholder-i18n]').each(function() {
        $(this).attr('placeholder', I18N[this.dataset.placeholderI18n]);
    });

    $('html').attr('lang', I18N['lang']);

    w.local = function() {
        if ($('#search').val()) {
            window.location.href = "?type=query&query=" + encodeURIComponent($('#search').val());
        } else {
            const alertText = I18N && I18N['name-not-filled'] ? I18N['name-not-filled'] : "NAME-NOT-FILLED-I18N";
            alert(alertText);
        }
    }
}) (window);