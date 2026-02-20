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

        return $.ajax({
            url: `./static/i18n/${lang}.json`,
            dataType: 'json',
            method: 'GET',
            async: false,
            success: data => res = data,
            error: () => alert('The language file error(s) was​/were detected: ' + lang)
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
}) (window);