<?php

class ImageTool {

    public static function resize($filename, $width, $height) {
        if (!file_exists(Yii::app()->params['imagePath'] . $filename) || !is_file(Yii::app()->params['imagePath'] . $filename)) {
            return;
        }

        $info = pathinfo($filename);

        $extension = $info['extension'];

        $old_image = $filename;
        $new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

        if (!file_exists(Yii::app()->params['imagePath'] . $new_image) || (filemtime(Yii::app()->params['imagePath'] . $old_image) > filemtime(Yii::app()->params['imagePath'] . $new_image))) {
            $path = '';

            $directories = explode('/', dirname(str_replace('../', '', $new_image)));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!file_exists(DIR_IMAGE . $path)) {
                    @mkdir(DIR_IMAGE . $path, 0777);
                }
            }

            $image = new Image(DIR_IMAGE . $old_image);
            $image->resize($width, $height);
            $image->save(DIR_IMAGE . $new_image);
        }

        return Yii::app()->baseUrl . '/image/' . $new_image;
    }

}

?>