BX.namespace('Ameton.Comments')

BX.Ameton.Comments = {
    signedParameters: null,
    init: function (data) {
        this.signedParameters = data.signedParameters
    },
    loadReplies: function (parentCommentId, level) {
        // Эмулируем подгруженные данные
        const parentComment = document.querySelector(`[data-comment-id="${parentCommentId}"] .comment-replies`);

        if (parentComment.isExpanded) {
            return
        }

        let signedParameters = this.signedParameters

        BX.ajax.runComponentAction('ameton:news.comments', 'getChildrenComments', {
            data: {
                parentCommentId: parentCommentId,
            },
            mode: 'class',
            signedParameters: signedParameters,
        }).then(response => {
            const replies = [
                {
                    id: 3,
                    author_name: 'bot_reply_1',
                    comment_text: 'This is a reply',
                    comment_date: '2024-10-14 03:00:00',
                    reply_count: 0,
                    level: level + 1
                },
                {
                    id: 4,
                    author_name: 'bot_reply_2',
                    comment_text: 'Another reply',
                    comment_date: '2024-10-14 03:05:00',
                    reply_count: 0,
                    level: level + 1
                }
            ];

            parentComment.isExpanded = true

            replies.forEach(function(reply) {
                const replyElement = document.createElement('div');
                replyElement.classList.add('comment');
                replyElement.dataset.commentId = reply.id;
                replyElement.dataset.level = reply.level;

                replyElement.innerHTML = `
                <div class="comment-author">${reply.author_name}</div>
                <div class="comment-text">${reply.comment_text}</div>
                <div class="comment-date">${reply.comment_date}</div>
                <div class="comment-replies"></div>
<!--                    <div class="load-replies">Ещё</div>-->
            `;

                parentComment.appendChild(replyElement);
            });
        })

    }
}
