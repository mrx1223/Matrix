<?php
if (isset($request->image)) {
 if (isset($model->image)) {
  $model->image->delete();
  $model->addMediaFromRequest("image")
   ->sanitizingFileName(function ($fileName) {
    return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
   })
   ->toMediaCollection();
 } else {
  $model->addMediaFromRequest("image")
   ->sanitizingFileName(function ($fileName) {
    return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
   })
   ->toMediaCollection();
 }
}

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
implements HasMedia

use InteractsWithMedia;
public function image(): HasOne
    {
        return $this->hasOne(Media::class, 'model_id')
            ->select("id", "file_name", "model_id", "disk")->where("model_type", "=", "App\Models\Model");
    }