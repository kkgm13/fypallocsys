tinymce.init({
    selector:'textarea#description',
    height: 250,
    resize: false,
    menu: [],
    toolbar: 'undo redo | formatselect fontsizeselect | bold italic underline link removeformat | hr charmap | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code preview ',
    plugins: ['advlist autolink codesample link lists charmap hr help preview wordcount code nonbreaking paste'],
});