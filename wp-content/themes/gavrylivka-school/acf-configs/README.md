# ACF Configuration для Gavrylivka School Theme

## Установка ACF полей

### 1. Hero Section Fields

Файл: `hero-section-fields.json`

**Импорт:**
1. Идите в админку WordPress: **Custom Fields → Tools**
2. Выберите **Import Field Groups**
3. Загрузите файл `hero-section-fields.json`
4. Нажмите **Import**

**Созданные поля:**
- `hero_title` - Заголовок секции
- `hero_subtitle` - Подзаголовок
- `hero_primary_button_text` - Текст главной кнопки  
- `hero_primary_button_link` - Ссылка главной кнопки
- `hero_secondary_button_text` - Текст второй кнопки
- `hero_secondary_button_link` - Ссылка второй кнопки
- `hero_gallery` - Галерея изображений для слайдера

**Настройки слайдера:** Автоплей всегда включен, скорость 3.5 секунды (зафиксировано в коде)

### 2. Где найти поля

После импорта поля появятся при редактировании страницы с шаблоном "Головна" (home.php).

### 3. Fallback значения

Если ACF поля не заполнены, используются значения по умолчанию:
- Заголовок: "Gavrylivka School"
- Подзаголовок: "Сучасна освіта для майбутнього вашої дитини"
- Кнопка 1: "Дізнатися більше" → "#about"
- Кнопка 2: "Зв'язатися з нами" → "tel:+380671234567"
- Слайдер: автоплей включен, скорость 3.5 секунды

### 4. Обратная совместимость

Код поддерживает старые поля `main_banner_1`, `main_banner_2`, `main_banner_3` если новое поле `hero_gallery` не заполнено.

## Требования

- Advanced Custom Fields PRO или бесплатная версия
- WordPress 5.0+
