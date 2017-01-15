
echo 'RUNNING PHPUNIT'
phpunit

echo 'RUNNING PHPCS'
phpcs src/ --standard=./vendor/escapestudios/symfony2-coding-standard/Symfony2/ruleset.xml

echo 'RUNNING PHPCPD'
phpcpd src/

echo 'RUNNING PHPMD'
phpmd src/ text ./phpmd.xml
