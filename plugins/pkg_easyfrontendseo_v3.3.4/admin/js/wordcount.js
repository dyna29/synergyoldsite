/*
 ---
 description: Gets word and character count

 license: MIT-style

 authors:
 - Virtuosi Media

 requires:
 - core/1.2.4: '*'

 provides: [WordCount]

 ...

 EFSEO - Easy Frontend SEO - https://joomla-extensions.kubik-rubik.de/efseo-easy-frontend-seo
 Modified version with countdown instead of countup.
 */
var WordCount = new Class({

    Implements: [Events, Options],

    options: {
        inputName: null,				//The input name from which text should be retrieved, defaults null
        countWords: true,				//Whether or not to count words
        countChars: true,				//Whether or not to count characters
        charText: 'characters',			//The text that follows the number of characters
        wordText: 'words',				//The text that follows the number of words
        separator: ', ',				//The text that separates the number of words and the number of characters
        liveCount: true,				//Whether or not to use the event trigger, set false if you'd like to call the getCount function separately
        eventTrigger: 'keyup'			//The event that triggers the count update
    },

    initialize: function (targetId, options) {
        this.setOptions(options);
        this.target = $(targetId);

        if ((this.options.liveCount) && (this.options.inputName)) {
            var input = $(document.body).getElement('[name=' + this.options.inputName + ']');
            input.addEvent(this.options.eventTrigger, function () {
                this.getCount(input.get('value'));
            }.bind(this));
        }
    },

    getCount: function (text) {
        var maxLength = parseInt($(document.body).getElement('[name=' + this.options.inputName + ']').get('maxlength'));
        var numChars = text.length;
        var numWords = (numChars != 0) ? text.clean().split(' ').length : 0;

        if ((this.options.countWords) && (this.options.countChars)) {
            var insertText = numWords + ' ' + this.options.wordText + this.options.separator + (maxLength - numChars) + ' ' + this.options.charText;
        } else {
            var insertText = (this.options.countWords) ? numWords + ' ' + this.options.wordText : (maxLength - numChars) + ' ' + this.options.charText;
        }

        if (insertText) {
            this.target.set('html', insertText);
        }
    }
});