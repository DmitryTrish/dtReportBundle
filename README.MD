# Symfony Report Bundle
by Dmitry Trish

## Installation

- Add composer package `$ composer require DmitryTrish/ReportBundle`
- Add `new DmitryTrish\ReportBundle\DmitryTrishReportBundle()` in **appKernel.php** $bundles array
- Update your DB schema `$ ./bin/console doctrine:schema:update --force`

## Usage

Get report service in your controller or whatever your want.

```php
$service = $this->get('dmitry_trish.report.report_service');
```

Then create a report form. It's handling request automatically.

```php
$form = $service->createForm();
```

Register submitted form by call **register** method.

```php
if ($form->isSubmitted() && $form->isValid()) {
    $service->register($form->getData());
}
```

### Advanced

You can register report without creating and handling form. Just create new Report instance and provide report text. Then register it.
```php
use DmitryTrish\ReportBundle\Entity\Report;
...

$report = new Report();
$report->setText('Some report text');

$service->register($report);
```