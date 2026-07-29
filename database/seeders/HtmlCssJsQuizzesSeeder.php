<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class HtmlCssJsQuizzesSeeder extends Seeder
{
    public function run(): void
    {
        $quizzes = [
            [
                'title' => 'HTML Quiz (50 Questions)',
                'description' => 'HTML fundamentals quiz — elements, attributes, forms, semantics, accessibility.',
                'time_limit_minutes' => 35,
                'questions' => $this->htmlQuestions(),
            ],
            [
                'title' => 'CSS Quiz (50 Questions)',
                'description' => 'CSS fundamentals quiz — selectors, box model, flexbox, grid, responsive design.',
                'time_limit_minutes' => 35,
                'questions' => $this->cssQuestions(),
            ],
            [
                'title' => 'JavaScript Quiz (50 Questions)',
                'description' => 'JavaScript fundamentals quiz — variables, functions, DOM, events, async basics.',
                'time_limit_minutes' => 40,
                'questions' => $this->jsQuestions(),
            ],
        ];

        foreach ($quizzes as $data) {
            $quiz = Quiz::updateOrCreate(
                ['title' => $data['title']],
                [
                    'description' => $data['description'],
                    'time_limit_minutes' => $data['time_limit_minutes'],
                    'is_published' => true,
                ]
            );

            $questions = $data['questions'];
            foreach ($questions as $i => $q) {
                QuizQuestion::updateOrCreate(
                    ['quiz_id' => $quiz->id, 'order' => $i + 1],
                    [
                        'question' => $q['question'],
                        'option_a' => $q['a'],
                        'option_b' => $q['b'],
                        'option_c' => $q['c'],
                        'option_d' => $q['d'],
                        'correct_option' => $q['correct'],
                    ]
                );
            }

            QuizQuestion::where('quiz_id', $quiz->id)
                ->where('order', '>', count($questions))
                ->delete();
        }
    }

    private function htmlQuestions(): array
    {
        return [
            ['question' => 'What does HTML stand for?', 'a' => 'HyperText Markup Language', 'b' => 'HighText Machine Language', 'c' => 'HyperTool Multi Language', 'd' => 'Home Tool Markup Language', 'correct' => 'a'],
            ['question' => 'Which tag is used for the largest heading?', 'a' => '<h6>', 'b' => '<h1>', 'c' => '<head>', 'd' => '<header>', 'correct' => 'b'],
            ['question' => 'Which attribute is used to provide an alternate text for an image?', 'a' => 'title', 'b' => 'src', 'c' => 'alt', 'd' => 'href', 'correct' => 'c'],
            ['question' => 'Which tag creates a hyperlink?', 'a' => '<link>', 'b' => '<a>', 'c' => '<href>', 'd' => '<url>', 'correct' => 'b'],
            ['question' => 'Which tag is used to create an unordered list?', 'a' => '<ol>', 'b' => '<ul>', 'c' => '<li>', 'd' => '<list>', 'correct' => 'b'],
            ['question' => 'Which tag is used to create a table row?', 'a' => '<td>', 'b' => '<tr>', 'c' => '<th>', 'd' => '<row>', 'correct' => 'b'],
            ['question' => 'Which tag defines the document type in HTML5?', 'a' => '<doctype html>', 'b' => '<!DOCTYPE html>', 'c' => '<doc>', 'd' => '<!DOC html>', 'correct' => 'b'],
            ['question' => 'Where should the <title> tag be placed?', 'a' => 'Inside <body>', 'b' => 'Inside <head>', 'c' => 'Inside <footer>', 'd' => 'Inside <main>', 'correct' => 'b'],
            ['question' => 'Which tag is used to insert a line break?', 'a' => '<lb>', 'b' => '<break>', 'c' => '<br>', 'd' => '<hr>', 'correct' => 'c'],
            ['question' => 'Which tag is used to create a horizontal rule?', 'a' => '<hr>', 'b' => '<line>', 'c' => '<br>', 'd' => '<rule>', 'correct' => 'a'],
            ['question' => 'Which element is used for emphasized text (default italic)?', 'a' => '<strong>', 'b' => '<em>', 'c' => '<i>', 'd' => '<b>', 'correct' => 'b'],
            ['question' => 'Which element is used for strong importance (default bold)?', 'a' => '<bold>', 'b' => '<b>', 'c' => '<strong>', 'd' => '<important>', 'correct' => 'c'],
            ['question' => 'Which tag is used to display a checkbox?', 'a' => '<input type="checkbox">', 'b' => '<checkbox>', 'c' => '<check>', 'd' => '<input type="check">', 'correct' => 'a'],
            ['question' => 'Which input type is used for a password field?', 'a' => 'text', 'b' => 'secret', 'c' => 'password', 'd' => 'hidden', 'correct' => 'c'],
            ['question' => 'Which tag is used to create a dropdown list?', 'a' => '<input type="dropdown">', 'b' => '<select>', 'c' => '<dropdown>', 'd' => '<optionlist>', 'correct' => 'b'],
            ['question' => 'Which tag defines an option in a dropdown list?', 'a' => '<choice>', 'b' => '<item>', 'c' => '<option>', 'd' => '<select-option>', 'correct' => 'c'],
            ['question' => 'Which element is used to group form controls?', 'a' => '<group>', 'b' => '<fieldset>', 'c' => '<section>', 'd' => '<formgroup>', 'correct' => 'b'],
            ['question' => 'What attribute is used to uniquely identify an element?', 'a' => 'class', 'b' => 'id', 'c' => 'name', 'd' => 'key', 'correct' => 'b'],
            ['question' => 'What attribute is used to specify the URL of a link?', 'a' => 'src', 'b' => 'href', 'c' => 'link', 'd' => 'url', 'correct' => 'b'],
            ['question' => 'Which element is semantic and typically contains navigation links?', 'a' => '<nav>', 'b' => '<menu>', 'c' => '<navigation>', 'd' => '<links>', 'correct' => 'a'],
            ['question' => 'Which element is semantic and typically contains main content?', 'a' => '<content>', 'b' => '<main>', 'c' => '<section>', 'd' => '<article>', 'correct' => 'b'],
            ['question' => 'Which element represents independent, self-contained content?', 'a' => '<article>', 'b' => '<div>', 'c' => '<span>', 'd' => '<section>', 'correct' => 'a'],
            ['question' => 'Which element is used to embed an external webpage?', 'a' => '<embed>', 'b' => '<iframe>', 'c' => '<frame>', 'd' => '<object>', 'correct' => 'b'],
            ['question' => 'Which attribute opens a link in a new tab?', 'a' => 'target="_blank"', 'b' => 'new="tab"', 'c' => 'open="new"', 'd' => 'blank="true"', 'correct' => 'a'],
            ['question' => 'Which element is used to associate a label with a form input?', 'a' => '<tag>', 'b' => '<label>', 'c' => '<caption>', 'd' => '<name>', 'correct' => 'b'],
            ['question' => 'Which attribute on <label> connects it to an <input> id?', 'a' => 'for', 'b' => 'id', 'c' => 'name', 'd' => 'connect', 'correct' => 'a'],
            ['question' => 'Which tag is used to include JavaScript in HTML?', 'a' => '<js>', 'b' => '<javascript>', 'c' => '<script>', 'd' => '<code>', 'correct' => 'c'],
            ['question' => 'Which tag is used to link an external CSS file?', 'a' => '<style src="...">', 'b' => '<css>', 'c' => '<link rel="stylesheet" href="...">', 'd' => '<stylesheet>', 'correct' => 'c'],
            ['question' => 'What is the correct HTML element for playing video?', 'a' => '<media>', 'b' => '<movie>', 'c' => '<video>', 'd' => '<player>', 'correct' => 'c'],
            ['question' => 'What is the correct HTML element for playing audio?', 'a' => '<sound>', 'b' => '<audio>', 'c' => '<mp3>', 'd' => '<music>', 'correct' => 'b'],
            ['question' => 'Which attribute is used in <form> to specify where to send data?', 'a' => 'action', 'b' => 'method', 'c' => 'target', 'd' => 'route', 'correct' => 'a'],
            ['question' => 'Which HTTP method is commonly used for submitting form data?', 'a' => 'GET only', 'b' => 'POST only', 'c' => 'POST or GET', 'd' => 'PUT only', 'correct' => 'c'],
            ['question' => 'Which tag is used to define the footer of a document/section?', 'a' => '<bottom>', 'b' => '<footer>', 'c' => '<end>', 'd' => '<foot>', 'correct' => 'b'],
            ['question' => 'Which element is inline by default?', 'a' => '<div>', 'b' => '<p>', 'c' => '<span>', 'd' => '<section>', 'correct' => 'c'],
            ['question' => 'Which element is block-level by default?', 'a' => '<span>', 'b' => '<a>', 'c' => '<div>', 'd' => '<img>', 'correct' => 'c'],
            ['question' => 'Which element is used to define a paragraph?', 'a' => '<para>', 'b' => '<p>', 'c' => '<paragraph>', 'd' => '<text>', 'correct' => 'b'],
            ['question' => 'Which tag is used to define an HTML document head section?', 'a' => '<header>', 'b' => '<head>', 'c' => '<top>', 'd' => '<metahead>', 'correct' => 'b'],
            ['question' => 'Which tag is used to define metadata such as character set?', 'a' => '<data>', 'b' => '<meta>', 'c' => '<info>', 'd' => '<charset>', 'correct' => 'b'],
            ['question' => 'Which attribute specifies the character encoding?', 'a' => 'encode', 'b' => 'charset', 'c' => 'char', 'd' => 'lang', 'correct' => 'b'],
            ['question' => 'Which tag is used to create an ordered list?', 'a' => '<list>', 'b' => '<ol>', 'c' => '<ul>', 'd' => '<li>', 'correct' => 'b'],
            ['question' => 'Which tag represents a list item?', 'a' => '<li>', 'b' => '<item>', 'c' => '<ul-item>', 'd' => '<ol-item>', 'correct' => 'a'],
            ['question' => 'Which element is used to mark up a short inline quotation?', 'a' => '<quote>', 'b' => '<q>', 'c' => '<blockquote>', 'd' => '<cite>', 'correct' => 'b'],
            ['question' => 'Which element is used for a long quotation block?', 'a' => '<q>', 'b' => '<blockquote>', 'c' => '<quote-block>', 'd' => '<longquote>', 'correct' => 'b'],
            ['question' => 'Which element is used to mark up code?', 'a' => '<code>', 'b' => '<pre>', 'c' => '<kbd>', 'd' => '<samp>', 'correct' => 'a'],
            ['question' => 'Which element preserves whitespace and line breaks?', 'a' => '<code>', 'b' => '<pre>', 'c' => '<space>', 'd' => '<text>', 'correct' => 'b'],
            ['question' => 'Which attribute makes an input field required?', 'a' => 'required', 'b' => 'validate', 'c' => 'mandatory', 'd' => 'must', 'correct' => 'a'],
            ['question' => 'Which input type is used for email validation?', 'a' => 'text', 'b' => 'email', 'c' => 'mail', 'd' => 'address', 'correct' => 'b'],
            ['question' => 'Which tag is used to group related content with a caption?', 'a' => '<figure>', 'b' => '<img>', 'c' => '<picture>', 'd' => '<caption>', 'correct' => 'a'],
            ['question' => 'Which tag provides a caption for <figure>?', 'a' => '<figcaption>', 'b' => '<caption>', 'c' => '<legend>', 'd' => '<title>', 'correct' => 'a'],
            ['question' => 'Which tag is used to define the body of the document?', 'a' => '<content>', 'b' => '<body>', 'c' => '<page>', 'd' => '<main>', 'correct' => 'b'],
        ];
    }

    private function cssQuestions(): array
    {
        return [
            ['question' => 'What does CSS stand for?', 'a' => 'Computer Style Sheets', 'b' => 'Cascading Style Sheets', 'c' => 'Creative Style System', 'd' => 'Colorful Style Sheets', 'correct' => 'b'],
            ['question' => 'Which property changes the text color?', 'a' => 'font-color', 'b' => 'text-color', 'c' => 'color', 'd' => 'foreground', 'correct' => 'c'],
            ['question' => 'Which property changes the background color?', 'a' => 'background-color', 'b' => 'bgcolor', 'c' => 'color', 'd' => 'background', 'correct' => 'a'],
            ['question' => 'Which selector targets an element by id?', 'a' => '.id', 'b' => '#id', 'c' => 'id()', 'd' => '*id', 'correct' => 'b'],
            ['question' => 'Which selector targets an element by class?', 'a' => '#class', 'b' => '.class', 'c' => 'class()', 'd' => '*class', 'correct' => 'b'],
            ['question' => 'Which property sets the size of text?', 'a' => 'text-size', 'b' => 'font-size', 'c' => 'size', 'd' => 'font-style', 'correct' => 'b'],
            ['question' => 'Which property sets the font family?', 'a' => 'font-type', 'b' => 'font-family', 'c' => 'text-font', 'd' => 'family', 'correct' => 'b'],
            ['question' => 'Which property makes text bold?', 'a' => 'font-style: bold', 'b' => 'font-weight: bold', 'c' => 'text-bold: true', 'd' => 'weight: bold', 'correct' => 'b'],
            ['question' => 'Which property controls space outside the border?', 'a' => 'padding', 'b' => 'margin', 'c' => 'border-spacing', 'd' => 'outline', 'correct' => 'b'],
            ['question' => 'Which property controls space inside the border?', 'a' => 'padding', 'b' => 'margin', 'c' => 'gap', 'd' => 'spacing', 'correct' => 'a'],
            ['question' => 'Which property sets the border of an element?', 'a' => 'outline', 'b' => 'border', 'c' => 'stroke', 'd' => 'edge', 'correct' => 'b'],
            ['question' => 'Which property rounds the corners of an element?', 'a' => 'corner-radius', 'b' => 'border-round', 'c' => 'border-radius', 'd' => 'radius', 'correct' => 'c'],
            ['question' => 'Which property sets element width?', 'a' => 'width', 'b' => 'size-x', 'c' => 'box-width', 'd' => 'w', 'correct' => 'a'],
            ['question' => 'Which property sets element height?', 'a' => 'height', 'b' => 'size-y', 'c' => 'box-height', 'd' => 'h', 'correct' => 'a'],
            ['question' => 'Which display value makes an element a flex container?', 'a' => 'display: flex', 'b' => 'display: grid', 'c' => 'display: block', 'd' => 'display: inline', 'correct' => 'a'],
            ['question' => 'Which flexbox property controls the main-axis alignment?', 'a' => 'align-items', 'b' => 'justify-content', 'c' => 'align-content', 'd' => 'place-items', 'correct' => 'b'],
            ['question' => 'Which flexbox property controls the cross-axis alignment of items?', 'a' => 'justify-content', 'b' => 'align-items', 'c' => 'align-self', 'd' => 'order', 'correct' => 'b'],
            ['question' => 'Which property creates space between flex items (modern CSS)?', 'a' => 'space', 'b' => 'gap', 'c' => 'padding', 'd' => 'margin-gap', 'correct' => 'b'],
            ['question' => 'Which display value enables CSS Grid?', 'a' => 'display: flex', 'b' => 'display: grid', 'c' => 'display: table', 'd' => 'display: inline-grid-only', 'correct' => 'b'],
            ['question' => 'Which property defines columns in grid?', 'a' => 'grid-columns', 'b' => 'grid-template-columns', 'c' => 'grid-column-count', 'd' => 'columns', 'correct' => 'b'],
            ['question' => 'Which unit is relative to the root font-size?', 'a' => 'em', 'b' => 'rem', 'c' => 'px', 'd' => '%', 'correct' => 'b'],
            ['question' => 'Which unit is relative to the viewport width?', 'a' => 'vw', 'b' => 'vh', 'c' => 'vmin', 'd' => 'ch', 'correct' => 'a'],
            ['question' => 'Which unit is relative to the viewport height?', 'a' => 'vw', 'b' => 'vh', 'c' => 'vmax', 'd' => 'pt', 'correct' => 'b'],
            ['question' => 'Which property hides overflow content?', 'a' => 'overflow: hidden', 'b' => 'display: none', 'c' => 'visibility: hidden', 'd' => 'clip: hide', 'correct' => 'a'],
            ['question' => 'Which property makes an element invisible but keeps its space?', 'a' => 'display: none', 'b' => 'opacity: 0', 'c' => 'visibility: hidden', 'd' => 'hidden: true', 'correct' => 'c'],
            ['question' => 'Which property removes an element from layout?', 'a' => 'visibility: hidden', 'b' => 'opacity: 0', 'c' => 'display: none', 'd' => 'z-index: -1', 'correct' => 'c'],
            ['question' => 'Which property changes the transparency?', 'a' => 'alpha', 'b' => 'transparent', 'c' => 'opacity', 'd' => 'visibility', 'correct' => 'c'],
            ['question' => 'Which property sets position relative to the nearest positioned ancestor?', 'a' => 'position: relative', 'b' => 'position: absolute', 'c' => 'position: fixed', 'd' => 'position: sticky', 'correct' => 'b'],
            ['question' => 'Which position keeps an element relative to viewport when scrolling?', 'a' => 'relative', 'b' => 'absolute', 'c' => 'fixed', 'd' => 'static', 'correct' => 'c'],
            ['question' => 'Which property controls stacking order?', 'a' => 'z-index', 'b' => 'stack', 'c' => 'layer', 'd' => 'order', 'correct' => 'a'],
            ['question' => 'Which pseudo-class targets an element on mouse hover?', 'a' => ':active', 'b' => ':focus', 'c' => ':hover', 'd' => ':visited', 'correct' => 'c'],
            ['question' => 'Which pseudo-class targets the first child element?', 'a' => ':first', 'b' => ':first-child', 'c' => ':child(1)', 'd' => ':nth(0)', 'correct' => 'b'],
            ['question' => 'Which selector targets all elements?', 'a' => 'all', 'b' => '*', 'c' => 'body', 'd' => '.', 'correct' => 'b'],
            ['question' => 'Which property sets the line height?', 'a' => 'line-height', 'b' => 'text-height', 'c' => 'leading', 'd' => 'height-line', 'correct' => 'a'],
            ['question' => 'Which property adds a shadow to text?', 'a' => 'box-shadow', 'b' => 'text-shadow', 'c' => 'shadow', 'd' => 'font-shadow', 'correct' => 'b'],
            ['question' => 'Which property adds a shadow to a box?', 'a' => 'text-shadow', 'b' => 'box-shadow', 'c' => 'shadow-box', 'd' => 'filter: shadow', 'correct' => 'b'],
            ['question' => 'Which property changes the cursor style?', 'a' => 'mouse', 'b' => 'cursor', 'c' => 'pointer', 'd' => 'hand', 'correct' => 'b'],
            ['question' => 'Which @rule is used for responsive design breakpoints?', 'a' => '@responsive', 'b' => '@media', 'c' => '@breakpoint', 'd' => '@screen', 'correct' => 'b'],
            ['question' => 'Which property centers text horizontally?', 'a' => 'align: center', 'b' => 'text-align: center', 'c' => 'justify: center', 'd' => 'font-align: center', 'correct' => 'b'],
            ['question' => 'Which property underlines text?', 'a' => 'text-style: underline', 'b' => 'font-decoration: underline', 'c' => 'text-decoration: underline', 'd' => 'decorate: underline', 'correct' => 'c'],
            ['question' => 'Which shorthand sets margin on all sides?', 'a' => 'margin', 'b' => 'padding', 'c' => 'border', 'd' => 'space', 'correct' => 'a'],
            ['question' => 'Which property changes list bullet style?', 'a' => 'bullet-style', 'b' => 'list-type', 'c' => 'list-style-type', 'd' => 'ul-style', 'correct' => 'c'],
            ['question' => 'Which property sets a background image?', 'a' => 'background-image', 'b' => 'image-background', 'c' => 'bg-image', 'd' => 'background: photo', 'correct' => 'a'],
            ['question' => 'Which property controls how a background image repeats?', 'a' => 'background-repeat', 'b' => 'background-loop', 'c' => 'image-repeat', 'd' => 'repeat-image', 'correct' => 'a'],
            ['question' => 'Which property sets the size of a background image?', 'a' => 'background-scale', 'b' => 'background-size', 'c' => 'image-size', 'd' => 'bg-size', 'correct' => 'b'],
            ['question' => 'Which property animates changes over time?', 'a' => 'animation', 'b' => 'transition', 'c' => 'transform', 'd' => 'motion', 'correct' => 'b'],
            ['question' => 'Which property rotates/scales/translates an element?', 'a' => 'transition', 'b' => 'transform', 'c' => 'translate', 'd' => 'motion', 'correct' => 'b'],
            ['question' => 'Which property sets the box sizing model?', 'a' => 'box-model', 'b' => 'box-sizing', 'c' => 'sizing', 'd' => 'border-box', 'correct' => 'b'],
            ['question' => 'Which value makes width include padding and border?', 'a' => 'content-box', 'b' => 'border-box', 'c' => 'padding-box', 'd' => 'layout-box', 'correct' => 'b'],
            ['question' => 'Which selector targets elements with attribute [disabled]?', 'a' => ':disabled', 'b' => '[disabled]', 'c' => 'disabled()', 'd' => '#disabled', 'correct' => 'b'],
            ['question' => 'Which property sets the spacing between letters?', 'a' => 'word-spacing', 'b' => 'letter-spacing', 'c' => 'text-spacing', 'd' => 'font-spacing', 'correct' => 'b'],
            ['question' => 'Which property sets the spacing between words?', 'a' => 'word-spacing', 'b' => 'letter-spacing', 'c' => 'line-spacing', 'd' => 'spacing', 'correct' => 'a'],
        ];
    }

    private function jsQuestions(): array
    {
        return [
            ['question' => 'Which keyword declares a block-scoped variable?', 'a' => 'var', 'b' => 'let', 'c' => 'define', 'd' => 'constantly', 'correct' => 'b'],
            ['question' => 'Which keyword declares a constant (cannot be reassigned)?', 'a' => 'var', 'b' => 'let', 'c' => 'const', 'd' => 'static', 'correct' => 'c'],
            ['question' => 'Which type is returned by typeof null?', 'a' => 'null', 'b' => 'object', 'c' => 'undefined', 'd' => 'number', 'correct' => 'b'],
            ['question' => 'Which operator checks strict equality?', 'a' => '==', 'b' => '=', 'c' => '===', 'd' => '!=', 'correct' => 'c'],
            ['question' => 'Which method converts JSON string to object?', 'a' => 'JSON.parse()', 'b' => 'JSON.stringify()', 'c' => 'JSON.toObject()', 'd' => 'JSON.decode()', 'correct' => 'a'],
            ['question' => 'Which method converts object to JSON string?', 'a' => 'JSON.parse()', 'b' => 'JSON.stringify()', 'c' => 'JSON.encode()', 'd' => 'JSON.toString()', 'correct' => 'b'],
            ['question' => 'How do you write a single-line comment in JavaScript?', 'a' => '<!-- -->', 'b' => '# comment', 'c' => '// comment', 'd' => '/* comment */', 'correct' => 'c'],
            ['question' => 'Which is a correct function declaration?', 'a' => 'function myFunc() {}', 'b' => 'func myFunc() {}', 'c' => 'def myFunc() {}', 'd' => 'function: myFunc() {}', 'correct' => 'a'],
            ['question' => 'Which array method adds an element to the end?', 'a' => 'push()', 'b' => 'pop()', 'c' => 'shift()', 'd' => 'unshift()', 'correct' => 'a'],
            ['question' => 'Which array method removes the last element?', 'a' => 'push()', 'b' => 'pop()', 'c' => 'shift()', 'd' => 'unshift()', 'correct' => 'b'],
            ['question' => 'Which method selects the first element that matches a CSS selector?', 'a' => 'document.getElementByClass()', 'b' => 'document.querySelector()', 'c' => 'document.select()', 'd' => 'document.find()', 'correct' => 'b'],
            ['question' => 'Which method selects all elements that match a CSS selector?', 'a' => 'document.querySelectorAll()', 'b' => 'document.getElements()', 'c' => 'document.selectAll()', 'd' => 'document.findAll()', 'correct' => 'a'],
            ['question' => 'Which event fires when a button is clicked?', 'a' => 'press', 'b' => 'tap', 'c' => 'click', 'd' => 'mouse', 'correct' => 'c'],
            ['question' => 'Which method attaches an event listener?', 'a' => 'addEventListener()', 'b' => 'on()', 'c' => 'attach()', 'd' => 'listen()', 'correct' => 'a'],
            ['question' => 'What does NaN stand for?', 'a' => 'Not a Name', 'b' => 'Name as Number', 'c' => 'Not a Number', 'd' => 'Number as Name', 'correct' => 'c'],
            ['question' => 'Which is a falsy value?', 'a' => '"0"', 'b' => '[]', 'c' => '0', 'd' => '{}', 'correct' => 'c'],
            ['question' => 'Which statement is used for conditional branching?', 'a' => 'if', 'b' => 'when', 'c' => 'switcher', 'd' => 'case', 'correct' => 'a'],
            ['question' => 'Which loop repeats while a condition is true?', 'a' => 'for', 'b' => 'repeat', 'c' => 'while', 'd' => 'loop', 'correct' => 'c'],
            ['question' => 'Which keyword stops a loop immediately?', 'a' => 'stop', 'b' => 'break', 'c' => 'return', 'd' => 'exit', 'correct' => 'b'],
            ['question' => 'Which keyword skips to the next iteration?', 'a' => 'continue', 'b' => 'next', 'c' => 'skip', 'd' => 'pass', 'correct' => 'a'],
            ['question' => 'What is the output of Boolean("")?', 'a' => 'true', 'b' => 'false', 'c' => 'null', 'd' => 'undefined', 'correct' => 'b'],
            ['question' => 'Which operator is used for logical AND?', 'a' => '&', 'b' => '&&', 'c' => 'and', 'd' => '||', 'correct' => 'b'],
            ['question' => 'Which operator is used for logical OR?', 'a' => '|', 'b' => 'or', 'c' => '||', 'd' => '&&', 'correct' => 'c'],
            ['question' => 'Which built-in object represents dates?', 'a' => 'Time', 'b' => 'Date', 'c' => 'Clock', 'd' => 'Calendar', 'correct' => 'b'],
            ['question' => 'Which method converts a string to an integer?', 'a' => 'int()', 'b' => 'parseInt()', 'c' => 'toInt()', 'd' => 'Number.int()', 'correct' => 'b'],
            ['question' => 'Which method converts a string to a number (float)?', 'a' => 'parseFloat()', 'b' => 'toFloat()', 'c' => 'float()', 'd' => 'Number.float()', 'correct' => 'a'],
            ['question' => 'Which object is the global object in browsers?', 'a' => 'global', 'b' => 'window', 'c' => 'process', 'd' => 'root', 'correct' => 'b'],
            ['question' => 'Which statement handles errors in code?', 'a' => 'try/catch', 'b' => 'do/except', 'c' => 'guard', 'd' => 'error/handle', 'correct' => 'a'],
            ['question' => 'Which keyword throws a custom error?', 'a' => 'throw', 'b' => 'raise', 'c' => 'error', 'd' => 'fail', 'correct' => 'a'],
            ['question' => 'Which of these creates a Promise?', 'a' => 'new Promise((resolve, reject) => {})', 'b' => 'Promise()', 'c' => 'create Promise {}', 'd' => 'make Promise()', 'correct' => 'a'],
            ['question' => 'Which keyword is used to wait for a Promise inside an async function?', 'a' => 'wait', 'b' => 'await', 'c' => 'pause', 'd' => 'yield', 'correct' => 'b'],
            ['question' => 'Which keyword declares an async function?', 'a' => 'async', 'b' => 'await', 'c' => 'defer', 'd' => 'promise', 'correct' => 'a'],
            ['question' => 'Which method runs a function after a delay?', 'a' => 'delay()', 'b' => 'setTimeout()', 'c' => 'setInterval()', 'd' => 'after()', 'correct' => 'b'],
            ['question' => 'Which method runs repeatedly on an interval?', 'a' => 'setTimeout()', 'b' => 'repeat()', 'c' => 'setInterval()', 'd' => 'tick()', 'correct' => 'c'],
            ['question' => 'Which keyword refers to the current object (method context)?', 'a' => 'self', 'b' => 'this', 'c' => 'me', 'd' => 'that', 'correct' => 'b'],
            ['question' => 'Which array method creates a new array by transforming elements?', 'a' => 'filter()', 'b' => 'map()', 'c' => 'reduce()', 'd' => 'forEach()', 'correct' => 'b'],
            ['question' => 'Which array method creates a new array with elements passing a test?', 'a' => 'map()', 'b' => 'filter()', 'c' => 'reduce()', 'd' => 'sort()', 'correct' => 'b'],
            ['question' => 'Which array method reduces an array to a single value?', 'a' => 'reduce()', 'b' => 'sum()', 'c' => 'collapse()', 'd' => 'combine()', 'correct' => 'a'],
            ['question' => 'Which method finds an element in an array?', 'a' => 'find()', 'b' => 'search()', 'c' => 'locate()', 'd' => 'get()', 'correct' => 'a'],
            ['question' => 'Which statement declares a class?', 'a' => 'type MyClass {}', 'b' => 'class MyClass {}', 'c' => 'object MyClass {}', 'd' => 'struct MyClass {}', 'correct' => 'b'],
            ['question' => 'Which keyword creates a new instance of a class?', 'a' => 'new', 'b' => 'make', 'c' => 'create', 'd' => 'instance', 'correct' => 'a'],
            ['question' => 'Which of these is used to import from another module (ESM)?', 'a' => 'include', 'b' => 'require', 'c' => 'import', 'd' => 'load', 'correct' => 'c'],
            ['question' => 'Which method stops event propagation?', 'a' => 'event.stop()', 'b' => 'event.stopPropagation()', 'c' => 'event.cancel()', 'd' => 'event.prevent()', 'correct' => 'b'],
            ['question' => 'Which method prevents default browser behavior?', 'a' => 'event.preventDefault()', 'b' => 'event.stopDefault()', 'c' => 'event.cancelDefault()', 'd' => 'event.disable()', 'correct' => 'a'],
            ['question' => 'What is the result of "5" + 2 in JavaScript?', 'a' => '7', 'b' => '"7"', 'c' => '"52"', 'd' => '52', 'correct' => 'c'],
            ['question' => 'What is the result of "5" - 2 in JavaScript?', 'a' => '3', 'b' => '"3"', 'c' => '"52"', 'd' => 'NaN', 'correct' => 'a'],
            ['question' => 'Which method converts a NodeList to an Array?', 'a' => 'Array.from(nodeList)', 'b' => 'nodeList.toArray()', 'c' => 'nodeList.array()', 'd' => 'Array(nodeList)', 'correct' => 'a'],
            ['question' => 'Which operator is used to provide a default when a value is null/undefined?', 'a' => '||', 'b' => '??', 'c' => '?:', 'd' => '&&', 'correct' => 'b'],
            ['question' => 'Which symbol starts a template literal?', 'a' => '"', 'b' => "'", 'c' => '`', 'd' => '~', 'correct' => 'c'],
            ['question' => 'Which syntax inserts an expression inside a template literal?', 'a' => '{{ expr }}', 'b' => '${ expr }', 'c' => '#{ expr }', 'd' => '$( expr )', 'correct' => 'b'],
        ];
    }
}
