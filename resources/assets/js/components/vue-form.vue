<template>
  <div class="container">
    <div class="form-group">
      <input type="title" class="form-control" v-model="title">
    </div>
    <div class="form-group">
      <textarea class="form-control" v-model="content" id="textarea"></textarea>
    </div>
    <div class="form-group">
      <button @click="submitForm">submit</button>
    </div>
  </div>
</template>
<script>
    var editor_config = {};

export default {
  mounted () {
     const self = this
    tinymce.init({
    path_absolute : "http://vueuploader.dev",
    selector: "textarea",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern codesample"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | codesample | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    init_instance_callback: function (editor) {
        editor.on('keyup', function (e) {
          self.content = e.target.innerHTML
        });
      },

    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = 'http://vueuploader.dev/laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  
    });
  },
  data () {
    return {
      title: '',
      content: ''
    }
  },
  methods: {
    submitForm () {
      console.log('hello world');
      axios.post('/post', {title: this.title, content: this.content }).then(() => {
        this.title = '';
        var tinymce_editor_id = 'textarea'; 
        tinymce.get(tinymce_editor_id).setContent('');
      })
    }
  }
}
</script>
