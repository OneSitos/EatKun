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

    w.init = function() {
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('./static/javascript/ServiceWorker.js')
                   .then(function(registration) { console.log('ServiceWorker Registration successful: ', registration.scope); })
                   .catch(function(err) { console.log('ServiceWorker Registration failed: ', err); });
            });
        }
    }

    w.local = function() {
        if ($('#search').val()) {
            window.location.href = "?type=query&query=" + encodeURIComponent($('#search').val());
        } else {
            const alertText = I18N && I18N['name-not-filled'] ? I18N['name-not-filled'] : "NAME-NOT-FILLED-I18N";
            alert(alertText);
        }
    }

    w.openWebpage = function(link) { // 使用了 https://github.com/Webpage-gh/eatcat 的代码，openWebpage 代码使用 https://raw.githubusercontent.com/OneSitos/EatKun/refs/heads/main/files/license/github.Webpage-gh.eatcat_LICENSE.txt 进行授权
        const confirmText = I18N && I18N['confirm-redirect'] + link ? I18N['confirm-redirect'] + link : "CONFIRM-REDIRECT-I18N\n" + link; // Display the confirmation prompt
        let confirmation = confirm(confirmText);
        if (confirmation) {
            window.location.href = link; // If the user confirms, proceed with the URL redirection
        }
    }
}) (window);