##Run server
<code>
docker-compose up
</code>

##Натройки первого запуска Laravel
<ol>
<li> Запустить web контейнер с проектом <code> docker-compose exec web bash </code></li>
<li> Проверить версию php: <code>php -v</code> (должна быть не меньше 8.1.14)</li>
<li> Запустить  <code>php composer.phar install</code> (загрузит все зависимости)</li>
<li> Убедиться, что выполнились post-install-cmd скрипты из composer.json файла
и появился в корне файл .env </li>
<li> Если post-install скрипты не выполнились, то:<ul>
<li> создать .env файл копией от .env.example </li>
<li> сгенерировать ключ: <code>php artisan key:generate</code></li>
</ul></li>
<li> Указали доступ к базе в файле .env:
<pre>
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_miniERP
DB_USERNAME=root
DB_PASSWORD=root
</pre>
</li>
</ol>


##Вход в контейнер докера
<ol>
<li> Запустить web контейнер с проектом <code> docker-compose exec web bash </code></li>
</ol>

## Update classes list to be included
<code>
php composer.phar dump-autoload
</code>


## Clear config cache if it was built while deploy process
<code>
php artisan config:clear
</code>  
<p>Важно при создании новый файлов конфигов в папке config/</p>

##Run simple php server without docker

<code>
php artisan serve --port=8099
</code>

## Update classes list to be included
<code>
php composer.phar dump-autoload
</code>


## Clear config cache if it was built while deploy process
<code>
php artisan config:clear
</code>  
<p>Важно при создании новый файлов конфигов в папке config/</p>
