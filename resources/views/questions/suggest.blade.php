@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Suggest a question</div>
				<form class="panel-body">

				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="usr">Answer type</label>
							<select class="form-control" id="question-type">
								<option value="1">Single line text</option>
								<option value="2">Multi-line text</option>
								<option value="3" selected="selected">Pick one</option>
								<option value="4">Check all that apply</option>
							</select>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="form-group">
							<label for="usr">Programming language</label>
							<select class="form-control" id="question-program-lang">
								<option value="java">Java</option>
								<option value="javascript" selected="selected">Javascript</option>
								<option value="ruby">Ruby</option>
								<option value="python">Python</option>
								<option value="perl">Perl</option>
								<option value="php">PHP</option>
								<option value="cs">C#</option>
								<option value="cpp">C++</option>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group question-categories">
					<label>Categories</label>
					<span class="hidden" id="t-categories-placeholder">E.g. OOP, Algorithms, Patterns</span>
					<ul id="question-categories">
					</ul>
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
Code example:

	function test(arg) {
		console.log(arg, 42, 'string');
	}

Question text...
</textarea>
								<div class="editor-hints">
									Use <a href="https://guides.github.com/features/mastering-markdown/">Markdown</a> 
									syntax and indent source code for highlighting
								</div>
						</div>
						<div id="markdown-view" class="hidden">
						</div>
					</div>
				</div>

				<div class="panel panel-default" id="question-answers-block">
					<div class="panel-heading">
						<span>Answers</span>
					</div>
					<div class="panel-body answers-container">
						<button class="btn btn-default add-answer">Add new answer</button>
						<span class="flag-correct-hint pull-right">
							Flag correct answers with
							<span class="glyphicon glyphicon-ok-circle answer-correct-ok"></span>
						</span>
						<input type="hidden" name="active-answers-type" id="active-answers-type" value="<?=$activeAnswerType?>" />
						<?php foreach([3 => 'radio', 4 => 'checkbox'] as $typeId => $inputType) { ?>
							<div id="active-answers-<?=$typeId?>" class="active-answers-area <?= ($activeAnswerType === $typeId) ?: 'hidden'; ?>">
								<?php foreach(['answer-template', '', ''] as $className) { ?>
									<div class="input-group answer-wrapper <?=$className?>">
										<span class="input-group-addon answer-correct-toggle answer-correct-wrong">
											<label class="glyphicon glyphicon-remove-circle"></label>
											<input type="<?=$inputType?>" class="correct-switch" name="answersCorrect[<?=$typeId?>][]">
										</span>
										<input type="text" class="form-control" name="answers[<?=$typeId?>][]">
										<span class="input-group-btn">
											<button class="btn btn-default answer-remove">Remove</button>
										</span>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary pull-right">Submit new question</button>
			</form>
		</div>
	</div>
</div>
@endsection
