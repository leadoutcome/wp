(function() {
    tinymce.PluginManager.add('vop_mce_button', function(editor, url) {
        editor.addButton('vop_mce_button', {
            icon: 'custom-mce-icon',
            text: 'Overplay',
            onclick: function() {
                editor.windowManager.open({
                    title: 'Insert Video Overplay',
                    body: [{
                        type: 'textbox',
                        name: 'youtube_video',
                        label: 'Youtube Video URL:(optional)',
                        values: '',
                    },{
                        type: 'listbox',
                        name: 'overplay',
                        label: 'Select Overplay',
                        values: tinymce_vop_plugin_options
                    }, ],
                    onsubmit: function(e) {
                        editor.insertContent(
                            '[vop id=&quot;' +
                            e.data.overplay +
                            '&quot; video=&quot;' + e.data.youtube_video + '&quot; ]');
                    }
                });
            }
        });
    });
})();