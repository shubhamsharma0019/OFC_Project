<script>
    (() => {
        const scopedKeys = new Set([
            'ofc_auth_token',
            'ofc_auth_user',
            'onlyfreshers_token',
            'onlyfreshers_user',
            'ofc_fresher_token',
            'ofc_fresher_user',
            'onlyfreshers_company_token',
            'onlyfreshers_company_user',
            'ofc_company_token',
            'ofc_company_user',
            'ofc_training_partner_token',
            'ofc_training_partner_user',
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
            if (key.includes('token')) {
                sessionStorage.removeItem('ofc_logged_out');
                original.removeItem('ofc_logged_out');
                sessionStorage.removeItem('ofc_fresher_logged_out');
                original.removeItem('ofc_fresher_logged_out');
                sessionStorage.removeItem('ofc_company_logged_out');
                original.removeItem('ofc_company_logged_out');
            }
            if (scopedKeys.has(key)) sessionStorage.setItem(key, value);
            original.setItem(key, value);
        };

        localStorage.removeItem = (key) => {
            if (scopedKeys.has(key)) sessionStorage.removeItem(key);
            original.removeItem(key);
        };
    })();
</script>
