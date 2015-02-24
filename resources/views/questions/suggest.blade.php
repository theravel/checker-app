@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Suggest a question</div>
				<div class="panel-body">
					
					<script src="/js/markdown-editor/marked.js"></script>
					<script src="/js/markdown-editor/highlight.pack.js"></script>
					<script src="/js/markdown-editor/codemirror.js"></script>
					<script src="/js/markdown-editor/xml.js"></script>
					<script src="/js/markdown-editor/markdown.js"></script>
					<script src="/js/markdown-editor/gfm.js"></script>
					<script src="/js/markdown-editor/javascript.js"></script>
					<script src="/js/markdown-editor/rawinflate.js"></script>
					<script src="/js/markdown-editor/rawdeflate.js"></script>
					<link rel="stylesheet" href="/css/markdown-editor/codemirror.css">
					<link rel="stylesheet" href="/css/markdown-editor/default.css">
					<link rel="stylesheet" href="/css/my.css">
					<?php /* https://github.com/jbt/markdown-editor */ ?>

				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="usr">Answer type</label>
							<select class="form-control">
								<option value="one">Single line text</option>
								<option value="two">Multi-line text</option>
								<option value="three">Pick one</option>
								<option value="four">Check all that apply</option>
							</select>
						</div>
					</div>
					
					<div class="col-lg-6">
						<div class="form-group">
							<label for="usr">Programming language</label>
							<select class="form-control">
								<option value="one">Java</option>
								<option value="two">Javascript</option>
								<option value="three">Ruby</option>
								<option value="three">Python</option>
								<option value="three">Perl</option>
								<option value="three">PHP</option>
								<option value="three">C#</option>
								<option value="three">C++</option>
							</select>
						</div>
					</div>
				</div>

				<div class="panel panel-default editor-panel" id="editor-area">
					<div class="panel-heading">
						<span class="question-text">Question text</span>
						<div class="btn-toolbar pull-right" role="toolbar" aria-label="...">
							<div class="btn-group" role="group" aria-label="...">
								<button id="editor-preview-btn" title="Preview mode" class="btn btn-default glyphicon glyphicon-eye-open"></button>
								<button id="editor-edit-btn" title="Edit mode" class="btn btn-default glyphicon glyphicon-edit hidden"></button>
								<a id="editor-help-btn" href="https://guides.github.com/features/mastering-markdown/" target="_blank" title="Syntax help" class="btn btn-default glyphicon glyphicon-question-sign"></a>
							</div>
							<div class="btn-group" role="group" aria-label="...">
								<button id="enable-fullscreen-btn" title="Fullscreen mode" class="btn btn-default glyphicon glyphicon-fullscreen"></button>
							</div>
							<div class="btn-group" role="group" aria-label="...">
								<button id="exit-fullscreen-btn" title="Exit fullscreen" class="btn btn-default glyphicon glyphicon-resize-small hidden"></button>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="panel-body">
						<div id="editor-input">
<textarea id="code">
# GitHub Flavored Markdown Editor
Usage samples:

- list item
- **bold item**

```javascript
function test(arg) {
	console.log(arg, 42, 'string');
}
```

```php
function test($arg = 42) use ($obj) {
	$obj->call($arg, 'string');
}
```
</textarea>
								<div class="editor-hints p">
									Use <a href="https://guides.github.com/features/mastering-markdown/">Markdown</a> 
									syntax, do not forget specifying programming language for code highlighting.
								</div>
						</div>
						<div id="editor-preview" class="hidden">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection