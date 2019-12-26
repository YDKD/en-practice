/*
 * @Descripttion: 
 * @version: 
 * @Author: YDKD
 * @Date: 2019-12-25 11:25:11
 * @LastEditors: YDKD
 * @LastEditTime: 2019-12-25 11:25:31
 */
$(function() {
    layui.use(['layer', 'element', 'form', 'upload'], function() {
        var layer = layui.layer,
            element = layui.element,
            form = layui.form,
            upload = layui.upload;
        var xhrOnProgress = function(fun) {
            xhrOnProgress.onprogress = fun;
            return function() {
                var xhr = $.ajaxSettings.xhr();
                if (typeof xhrOnProgress.onprogress !== 'function')
                    return xhr;
                if (xhrOnProgress.onprogress && xhr.upload) { xhr.upload.onprogress = xhrOnProgress.onprogress; }
                return xhr;
            }
        }
        var uploadFile = upload.render({
            elem: '#upload',
            url: 'api/upload',
            exts: 'jpg|png|jpeg',
            acceptMime: 'image/jpg, image/png, image/jpeg',
            xhr: xhrOnProgress,
            size: 1024 * 3,
            progress: function(value) { element.progress('upload_progress', value + '%') },
            before: function(obj) { $("#upload_progress").removeClass("layui-hide"); },
            done: function(res, index, upload) {
                layer.close(layer.index);
                if (res.code == 0) {
                    layer.msg("上传成功！");
                    console.log(res.src);
                    $("#upload_preview").html("<img alt='预览图' src='" + res.src + "' width='230px' height='146px' />");
                }
            },
            error: function(index, upload) {
                layer.close(layer.index);
                layer.confirm("上传失败，您是否要重新上传？", { btn: ['确定', '取消'], icon: 3, title: "提示" }, function() {
                    layer.closeAll();
                    uploadFile.upload();
                })
            }
        });
    })
})