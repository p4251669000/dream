<?php
/**
 * 公共上传公用页面
 * User: 谢锐
 * Date: 2015/5/22
 * Time: 10:15
 */
?>

<div id="uploadImageView">

    <div id="queue"></div>
    <input id="<?= $uploadId ?>" name="file_upload" type="file" multiple="false">
    <input type="hidden" id="<?= $imageId ?>" name="<?= $imageId ?>" value="<?= $imageUrl ?>"/>
    <script type="text/javascript">

        $(function () {
            $('#<?= $uploadId?>').uploadify({
                'buttonText': '选择图片',
                'fileSizeLimit': 3*1024,
                'fileTypeExts': '*.jpg;*.png;*.jpeg;*.gif',
                'swf': 'scripts/Uploadify/uploadify.swf',
                'uploader': 'public/uploadimageinfo',
                dataType: "json",
                'onUploadSuccess': function (file, data, response) {
                    var obj = eval('(' + data + ')');
                    if (obj.result) {
                        $("#<?= $imageId?>").val(obj.data);
                        $("#<?= $imageDisplay?>").attr("src", obj.data);
                    }
                    else {
                        alert("上传失败" + obj.data);
                    }
                }
            });
        });
    </script>
    <img id="<?= $imageDisplay ?>" src="<?= $imageUrl ?>" style="max-height: 120px;max-width: 120px;">
</div>
