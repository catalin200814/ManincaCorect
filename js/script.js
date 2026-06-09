document.addEventListener('DOMContentLoaded', function() {
    let currentLang = localStorage.getItem('language') || 'ro';
    let isDarkMode = localStorage.getItem('darkMode') === 'true';

    const translations = {
        ro: {
            features: 'Funcționalități', contact: 'Contact', login: 'Conectare', register: 'Înregistrare',
            logout: 'Delogare', dashboard: 'Dashboard', plan_weekly: 'Planificare săptămânală',
            shopping_list: 'Listă cumpărături', my_recipes: 'Rețetele mele', save: '💾 Salvează',
            add: '➕ Adaugă', welcome: 'Bine ai venit', welcome_desc: 'Planifică-ți mesele săptămânale',
            day: 'Ziua', breakfast: 'Mic dejun', lunch: 'Prânz', dinner: 'Cină',
            ingredients: 'Ingrediente:', empty_list: 'Nu ai produse în listă.',
            hero_title1: 'Planifică', hero_title2: 'inteligent.', hero_title3: 'Mănâncă mai bine.',
            hero_desc: 'Planifică mesele săptămânale în câteva minute și primești automat lista de cumpărături.',
            start_now: 'Începe acum', learn_more: 'Află mai multe',
            stat_users: 'utilizatori activi', stat_meals: 'mese planificate', stat_savings: 'timp economisit',
            weekly_plan: 'Plan săptămânal', monday: 'Luni', tuesday: 'Marți', wednesday: 'Miercuri', thursday: 'Joi',
            auto_list: 'Listă automată generată', what_we_offer: 'Ce oferim',
            features_title: 'Funcționalități principale', features_subtitle: 'Tot ce ai nevoie',
            plan_desc: 'Organizează mesele pe zile', shopping_desc: 'Generează instant lista',
            recipes_desc: 'Salvează rețetele tale', savings: 'Economii & Reducere risipă', savings_desc: 'Planifică inteligent și cheltuie mai puțin',
            quick_links: 'Link-uri rapide', all_rights: 'Toate drepturile rezervate',
            contact_title: 'Contactează-ne', contact_sub: 'Ai întrebări? Trimite-ne un mesaj',
            name: 'Nume', email: 'Email', message_label: 'Mesaj', send: 'Trimite mesaj',
            add_placeholder: 'Adaugă un produs...', footer_tagline: 'Planifică inteligent. Mănâncă mai bine.'
        },
        en: {
            features: 'Features', contact: 'Contact', login: 'Login', register: 'Register',
            logout: 'Logout', dashboard: 'Dashboard', plan_weekly: 'Weekly Plan',
            shopping_list: 'Shopping List', my_recipes: 'My Recipes', save: '💾 Save',
            add: '➕ Add', welcome: 'Welcome', welcome_desc: 'Plan your weekly meals',
            day: 'Day', breakfast: 'Breakfast', lunch: 'Lunch', dinner: 'Dinner',
            ingredients: 'Ingredients:', empty_list: 'No items in your list.',
            hero_title1: 'Plan', hero_title2: 'smart.', hero_title3: 'Eat better.',
            hero_desc: 'Plan your weekly meals in minutes and get the shopping list automatically.',
            start_now: 'Start now', learn_more: 'Learn more',
            stat_users: 'active users', stat_meals: 'meals planned', stat_savings: 'time saved',
            weekly_plan: 'Weekly plan', monday: 'Monday', tuesday: 'Tuesday', wednesday: 'Wednesday', thursday: 'Thursday',
            auto_list: 'Auto-generated list', what_we_offer: 'What we offer',
            features_title: 'Main Features', features_subtitle: 'Everything you need',
            plan_desc: 'Organize meals by day', shopping_desc: 'Instant shopping list',
            recipes_desc: 'Save your recipes', savings: 'Savings & Waste reduction', savings_desc: 'Plan smart and spend less',
            quick_links: 'Quick links', all_rights: 'All rights reserved',
            contact_title: 'Contact us', contact_sub: 'Questions? Send us a message',
            name: 'Name', email: 'Email', message_label: 'Message', send: 'Send message',
            add_placeholder: 'Add an item...', footer_tagline: 'Plan smart. Eat better.'
        },
        ru: {
            features: 'Функции', contact: 'Контакты', login: 'Вход', register: 'Регистрация',
            logout: 'Выход', dashboard: 'Панель', plan_weekly: 'План на неделю',
            shopping_list: 'Список покупок', my_recipes: 'Мои рецепты', save: '💾 Сохранить',
            add: '➕ Добавить', welcome: 'Добро пожаловать', welcome_desc: 'Планируйте питание',
            day: 'День', breakfast: 'Завтрак', lunch: 'Обед', dinner: 'Ужин',
            ingredients: 'Ингредиенты:', empty_list: 'Список пуст',
            hero_title1: 'Планируй', hero_title2: 'умно.', hero_title3: 'Питайся лучше.',
            hero_desc: 'Планируйте питание на неделю за минуты и получите список покупок автоматически.',
            start_now: 'Начать', learn_more: 'Узнать больше',
            stat_users: 'активных пользователей', stat_meals: 'планов питания', stat_savings: 'экономия времени',
            weekly_plan: 'План недели', monday: 'Понедельник', tuesday: 'Вторник', wednesday: 'Среда', thursday: 'Четверг',
            auto_list: 'Авто-список', what_we_offer: 'Что мы предлагаем',
            features_title: 'Основные функции', features_subtitle: 'Всё необходимое',
            plan_desc: 'Организация по дням', shopping_desc: 'Мгновенный список',
            recipes_desc: 'Сохраняйте рецепты', savings: 'Экономия', savings_desc: 'Умное планирование',
            quick_links: 'Быстрые ссылки', all_rights: 'Все права защищены',
            contact_title: 'Свяжитесь с нами', contact_sub: 'Есть вопросы? Напишите нам',
            name: 'Имя', email: 'Email', message_label: 'Сообщение', send: 'Отправить',
            add_placeholder: 'Добавить товар...', footer_tagline: 'Планируй умно. Питайся лучше.'
        }
    };

    function applyLanguage() {
        document.querySelectorAll('[data-translate]').forEach(el => {
            const key = el.getAttribute('data-translate');
            if (translations[currentLang] && translations[currentLang][key]) {
                if (el.tagName === 'INPUT' && el.placeholder) el.placeholder = translations[currentLang][key];
                else if (el.tagName === 'TEXTAREA' && el.placeholder) el.placeholder = translations[currentLang][key];
                else el.textContent = translations[currentLang][key];
            }
        });
        localStorage.setItem('language', currentLang);
    }

    function applyTheme() {
        if (isDarkMode) document.body.classList.add('dark-mode');
        else document.body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', isDarkMode);
    }

    const themeBtn = document.getElementById('theme-toggle');
    if (themeBtn) themeBtn.addEventListener('click', () => { isDarkMode = !isDarkMode; applyTheme(); });

    const langSelect = document.getElementById('lang-select');
    if (langSelect) {
        langSelect.addEventListener('change', (e) => { currentLang = e.target.value; applyLanguage(); });
        langSelect.value = currentLang;
    }

    applyTheme();
    applyLanguage();

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    
    document.querySelectorAll('.feature-card, .hero-content, .hero-visual').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});