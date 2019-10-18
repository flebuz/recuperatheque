
window.addEventListener('DOMContentLoaded', (event) => {
      var tagInput1 = new TagsInput({
        selector: 'input-tags',
      });
      var source_tags = document.getElementById("source-tags").value;
      var tags = source_tags.split(',');

      tags.forEach((tag, index) =>
      {
      tagInput1.addTag(tags[index]);
    });

});
