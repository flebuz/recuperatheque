(function( factory){

    if(typeof module == 'object' && typeof module.exports == 'object' )
        module.exports = factory();
    else if( typeof window == 'object')
        window.TagsInput = factory();
    else
        console.error('To use this library you need to either use browser or node.js [require()]');

})(function(){
    "use strict"

    var initialized = false

    // Plugin Constructor
    var TagsInput = function(opts){
        this.options = Object.assign(TagsInput.defaults , opts);
        this.init();
    }

    // Initialize the plugin
    TagsInput.prototype.init = function(opts){
        this.options = opts ? Object.assign(this.options, opts) : this.options;

        if(initialized)
            this.destroy();

        if(!(this.original_input = document.getElementById(this.options.selector)) ){
            console.error("tags-input couldn't find an element with the specified ID");
            return this;
        }

        this.arr = [];
        this.wrapper = document.createElement('div');
        this.input = document.createElement('input');
        init(this);
        initEvents(this);

        initialized =  true;
        return this;
    }

    // Add Tags
    TagsInput.prototype.addTag = function(string){

        if(this.anyErrors(string))
            return ;

        this.arr.push(string);
        var tagInput = this;

        var tag = document.createElement('span');
        tag.className = this.options.tagClass;
        tag.innerText = string;

        var closeIcon = document.createElement('a');
        closeIcon.innerHTML = '&times;';

        // delete the tag when icon is clicked
        closeIcon.addEventListener('click' , function(e){
            e.preventDefault();
            var tag = this.parentNode;

            for(var i =0 ;i < tagInput.wrapper.childNodes.length ; i++){
                if(tagInput.wrapper.childNodes[i] == tag)
                    tagInput.deleteTag(tag , i);
            }
        })


        tag.appendChild(closeIcon);
        this.wrapper.insertBefore(tag , this.input);
        this.original_input.value = this.arr.join(',');

        return this;
    }

    // Delete Tags
    TagsInput.prototype.deleteTag = function(tag , i){
        tag.remove();
        this.arr.splice( i , 1);
        this.original_input.value =  this.arr.join(',');
        return this;
    }

    // Make sure input string have no error with the plugin
    TagsInput.prototype.anyErrors = function(string){
        if( this.options.max != null && this.arr.length >= this.options.max ){
            console.log('max tags limit reached');
            return true;
        }

        if(!this.options.duplicate && this.arr.indexOf(string) != -1 ){
            console.log('duplicate found " '+string+' " ')
            return true;
        }

        return false;
    }

    // Add tags programmatically
    TagsInput.prototype.addData = function(array){
        var plugin = this;

        array.forEach(function(string){
            plugin.addTag(string);
        })
        return this;
    }

    // Get the Input String
    TagsInput.prototype.getInputString = function(){
        return this.arr.join(',');
    }


    // destroy the plugin
    TagsInput.prototype.destroy = function(){
        this.original_input.removeAttribute('hidden');

        delete this.original_input;
        var self = this;

        Object.keys(this).forEach(function(key){
            if(self[key] instanceof HTMLElement)
                self[key].remove();

            if(key != 'options')
                delete self[key];
        });

        initialized = false;
    }

    // Private function to initialize the tag input plugin
    function init(tags){
        tags.wrapper.appendChild(tags.input);
        tags.wrapper.classList.add(tags.options.wrapperClass);
        tags.original_input.setAttribute('hidden' , 'true');
        tags.original_input.parentNode.insertBefore(tags.wrapper , tags.original_input);
    }

    // initialize the Events
    function initEvents(tags){
        tags.wrapper.addEventListener('touchstart' ,function(){
          tags.input.classList.remove("invisible");
            tags.input.focus();

        });
        tags.wrapper.addEventListener('click' ,function(){
          tags.input.classList.remove("invisible");
            tags.input.focus();

        });
/*
        tags.input.addEventListener('keyup' , function(e){
          console.log("keyup");
            var str = tags.input.value.trim();

            if( !!(~[9 , 13 , 188, 59, 32].indexOf( e.keyCode ))  )
            {
                tags.input.value = null;
                if(str != "")
                //str= str.substring(0, str.length - 1);
                str = str.replace(',','');

                    tags.addTag(str);

            }

        });

    */

        tags.input.addEventListener('keyup' , function(e){

//M.toast({html:String.fromCharCode(e.which || e.keyCode)});
            var str = tags.input.value.trim();

                  //  var char = str.substring(str.length - 1, str.length);

                /*  var firstletter = str.substring(0, 1);
                  if (firstletter == ' ')
                  {str=str.substring(1, str.length);}*/

                /*  if ( !!(~[' '].indexOf( str[0] ))  )
                  {tags.input.value = null;} */

var charend = str.substring(str.length - 1, str.length);

                  var caretposition = getCaretPos(tags.input);
                    var char = str.substring(caretposition - 1, caretposition);
                    var kc = char.charCodeAt(0);

            if (( !!(~[',' , ';' , '.'].indexOf( char ))  ) || ( !!(~[',' , ';' , '.'].indexOf( charend ))  ))
            {

            str=escapeRegExp(str);
              //console.log("escaped: " +str);
              str=str.replace(/[,;.\\\\\/]/g, '');
              //console.log("replaced: "+str);

                tags.input.value = null;

                if(str != "")
                {
                    tags.addTag(str);
                  }

            }

        });

        tags.input.addEventListener('blur' , function(e){
            var str = tags.input.value.trim();
                tags.input.value = null;

                str=escapeRegExp(str);
                str=str.replace(/[,;.\\\\\/]/g, '');

                if(str != "")
                //str= str.substring(0, str.length - 1);
                {
                    tags.addTag(str);
                  }

                  if ((tags.original_input.value !== undefined) && (tags.original_input.value !== '') && (tags.original_input.value !== null))
                  {
                    tags.input.classList.add("invisible");}



        });
    }

    function getCaretPos(input) {
        // Internet Explorer Caret Position (TextArea)
        if (document.selection && document.selection.createRange) {
            var range = document.selection.createRange();
            var bookmark = range.getBookmark();
            var caret_pos = bookmark.charCodeAt(2) - 2;
        } else {
            // Firefox Caret Position (TextArea)
            if (input.setSelectionRange)
                var caret_pos = input.selectionStart;
        }

        return caret_pos;
    }

function replaceAll (string, search, replacement) {

    return string.replace(new RegExp(search, 'g'), replacement);
};

function escapeRegExp(str) {
  return str.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"); // $& means the whole matched string
}

    // Set All the Default Values
    TagsInput.defaults = {
        selector : '',
        wrapperClass : 'tags-input-wrapper',
        tagClass : 'tag',
        max : null,
        duplicate: false
    }

    return TagsInput;
});
