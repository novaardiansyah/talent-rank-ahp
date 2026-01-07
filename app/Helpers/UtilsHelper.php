<?php

use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

function carbonTranslatedFormat(string $date, string $format = 'd/m/Y H:i', string $locale = null): string
{
  if ($locale) Carbon::setLocale($locale);
  return Carbon::parse($date)->translatedFormat($format);
}

function toIndonesianCurrency(float $number = 0, int $precision = 0, string $currency = 'Rp', bool $showCurrency = true)
{
  $result = 0;

  if ($number < 0) {
    $result = '-' . $currency . number_format(abs($number), $precision, ',', '.');
  } else {
    $result = $currency . number_format($number, $precision, ',', '.');
  }

  if ($showCurrency)
    return $result;

  $replace = str_replace(range(0, 9), '-', $result);
  return $replace;
}
function getOptionMonths($short = false): array
{
  if ($short) {
    return [
      '01' => 'Jan',
      '02' => 'Feb',
      '03' => 'Mar',
      '04' => 'Apr',
      '05' => 'Mei',
      '06' => 'Jun',
      '07' => 'Jul',
      '08' => 'Agu',
      '09' => 'Sep',
      '10' => 'Okt',
      '11' => 'Nov',
      '12' => 'Des',
    ];
  }

  return [
    '1' => 'Januari',
    '2' => 'Februari',
    '3' => 'Maret',
    '4' => 'April',
    '5' => 'Mei',
    '6' => 'Juni',
    '7' => 'Juli',
    '8' => 'Agustus',
    '9' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
  ];
}

function textCapitalize($text)
{
  return trim(ucwords(strtolower($text)));
}

function textUpper($text)
{
  return trim(strtoupper($text));
}

function textLower($text)
{
  return trim(strtolower($text));
}

function saveActivityLog(array $data = [], $modelMorp = null): ActivityLog
{
  $causer = getUser();
  
  $model    = $data['model'] ?? '';
  $event    = $data['event'] ?? '';
  $changes  = [];
  $oldValue = [];

  if ($modelMorp) {
    $changes = collect($modelMorp->getDirty())
    ->except($modelMorp->getHidden());

    if ($event == 'Updated') {
      $oldValue = $changes->mapWithKeys(fn ($value, $key) => [$key => $modelMorp->getOriginal($key)])->toArray();
    }

    $changes  = $changes->toArray();
  }

  return ActivityLog::create(array_merge([
    'log_name'        => 'Resource',
    'description'     => "{$model} {$event} by {$causer->name}",
    'event'           => $event,
    'causer_type'     => User::class,
    'causer_id'       => $causer->id,
    'prev_properties' => $oldValue,
    'properties'      => $changes,
  ], $data));
}

function getUser(?int $userId = null): Collection | User | null
{
  if ($userId) {
    return User::find($userId);
  }

  return auth()->user() ?? User::find(1);
}

function copyFileWithRandomName(string $defaultPath): string
{
  $sourcePath = storage_path('app/public/' . $defaultPath);

  if (!file_exists($sourcePath)) {
    return $defaultPath;
  }

  $pathInfo = pathinfo($defaultPath);
  $extension = $pathInfo['extension'] ?? 'png';
  $directory = $pathInfo['dirname'];

  $randomName = Carbon::now()->format('YmdHis') . '_' . str()->random(12) . '.' . $extension;
  $newPath = $directory . '/' . $randomName;

  $targetPath = storage_path('app/public/' . $newPath);
  $targetDirectory = storage_path('app/public/' . $directory);

  if (!is_dir($targetDirectory)) {
    mkdir($targetDirectory, 0755, true);
  }

  if (copy($sourcePath, $targetPath)) {
    return $newPath;
  }

  return $defaultPath;
}

function normalizeValidationErrors(array $errors, $addPrefix = null, $removePrefix = null): array
{
  $normalizedErrors = [];

  foreach ($errors as $key => $messages) {
    if ($addPrefix) {
      $newKey = $addPrefix . $key;
    }

    if ($removePrefix && str_starts_with($key, $removePrefix)) {
      $newKey = substr($key, strlen($removePrefix));
    }

    $normalizedErrors[$newKey] = $messages;
  }

  return $normalizedErrors;
}

function sizeFormat(float $size): string
{
  $units = ['B', 'KB', 'MB', 'GB', 'TB'];
  $i = floor(log($size, 1024));
  return round($size / pow(1024, $i), 2) . ' ' . $units[$i];
}

function uuid(): string
{
  return Str::orderedUuid()->toString();
}
