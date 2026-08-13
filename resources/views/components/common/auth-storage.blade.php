<script>
    (() => {
        const scopedKeys = new Set([
            'ofc_auth_token',
            'ofc_auth_user',
            'onlyfreshers_token',
            'onlyfreshers_user',
            'onlyfreshers_company_token',
            'onlyfreshers_company_user',
            'onlyFreshersAdminLogin',
        ]);

        const original = {
            getItem: localStorage.getItem.bind(localStorage),
            setItem: localStorage.setItem.bind(localStorage),
            removeItem: localStorage.removeItem.bind(localStorage),
        };

        localStorage.getItem = (key) => scopedKeys.has(key) && sessionStorage.getItem(key) !== null
            ? sessionStorage.getItem(key)
            : original.getItem(key);

        localStorage.setItem = (key, value) => {
            if (scopedKeys.has(key)) sessionStorage.setItem(key, value);
            original.setItem(key, value);
        };

        localStorage.removeItem = (key) => {
            if (scopedKeys.has(key)) sessionStorage.removeItem(key);
            original.removeItem(key);
        };
    })();
</script>
