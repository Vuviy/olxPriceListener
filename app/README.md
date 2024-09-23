# Підписка на сповіщення зміни ціни оголошення в OLX

## Опис проєкту

Це сервіс, що дозволяє користувачам підписуватися на оголошення за допомогою своїх email-адрес. Після підписки система запускає чергу для перевірки ціни на оголошення, а також надсилає електронний лист для верифікації email-адреси користувача.

### Основні функціональні можливості:
- **Підписка на оголошення:** Користувач надсилає посилання на оголошення та свою електронну адресу.
- **Верифікація email:** Користувач може верифікувати свою email-адресу за посиланням.
- **Обробка через черги:** Для перевірки ціни оголошення використовуються cron який перевіряє ціну кожну хвилину.

## Вимоги

- Docker
- Docker Compose

## Інсталяція та налаштування

### Крок 1: Клонування проєкту

```bash
git clone https://github.com/Vuviy/olxPriceListener.git
cd olxPriceListener
```
### Крок 2: Налаштування .env

#### Скопіюйте файл .env.example у .env

```bash
cp .env.example .env
```

#### Внесіть зміни до вашого .env файлу для налаштування доступу до бази даних та інших сервісів

```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=olxPrice
DB_USERNAME=root
DB_PASSWORD=root
```
#### Для відправки email ви можете налаштувати своє з'єднання

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="OLX PriceListener"
```

#### або скористатись моїм
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=vova.banudz@gmail.com
MAIL_PASSWORD=xkpjqrljqmuleojp
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="OLX PriceListener"
```

### Крок 3: Запуск Docker контейнерів
#### Запустіть Docker

```bash
docker compose up --build -d
```

### Крок 4: Встановлення залежностей

```bash
docker exec -it php bash
composer install
```

### Крок 5: Міграція бази даних

```bash
php artisan migrate
```
## HTTP методи описані в файлі openapi.yaml
