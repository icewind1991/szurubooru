<?php
class AddCommentJob extends AbstractJob
{
	public function execute()
	{
		$user = Auth::getCurrentUser();
		$post = PostModel::findById($this->getArgument(JobArgs::POST_ID));
		$text = CommentModel::validateText($this->getArgument(JobArgs::TEXT));

		$comment = CommentModel::spawn();
		$comment->setCommenter($user);
		$comment->setPost($post);
		$comment->commentDate = time();
		$comment->text = $text;

		CommentModel::save($comment);
		LogHelper::log('{user} commented on {post}', [
			'user' => TextHelper::reprUser($user),
			'post' => TextHelper::reprPost($comment->getPost()->id)]);

		return $comment;
	}

	public function requiresPrivilege()
	{
		return Privilege::AddComment;
	}

	public function requiresAuthentication()
	{
		return true;
	}

	public function requiresConfirmedEmail()
	{
		return getConfig()->registration->needEmailForCommenting;
	}
}
