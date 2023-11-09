# phpfilemanager

Install:

```
composer require siestacat/php-hash-path
```

Usage:

```
use Siestacat\PhpHashPath\GenHashPath;

$hash = '6520c076303312b8ccfd231632a1f752';

$instance = new GenHashPath(2, 2);
echo $instance->getPathFileSystem($hash); //Output: 65/20/6520c076303312b8ccfd231632a1f752
echo $instance->getPathFileSystem($hash, false); //Output: 65/20

$instance = new GenHashPath(4, 3);
echo $instance->getPathFileSystem($hash); //Output: 6520/c076/3033/6520c076303312b8ccfd231632a1f752
echo $instance->getPathFileSystem($hash, false); //Output: 6520/c076/3033

```


Tests:

```
git clone https://github.com/SiestaCat/php-hash-path.git
cd php-hash-path
composer install
composer run-script test
```
