<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arResult
 */

?>
    <div class="comments-section">
        <div class="comment" data-comment-id="1" data-level="0">
            <div class="comment-author">bot0</div>
            <div class="comment-text">cavf56f3u7o7qctz</div>
            <div class="comment-date">2024-10-14 02:18:59</div>
            <div class="comment-replies" data-reply-count="0">
                <!-- Здесь будет кнопка загрузки ответов, если они есть -->
            </div>
        </div>

        <div class="comment" data-comment-id="2" data-level="1">
            <div class="comment-author">bot1</div>
            <div class="comment-text">ks1u2iwejyj52og7</div>
            <div class="comment-date">2024-10-14 02:18:59</div>
            <div class="comment-replies" data-reply-count="0">
                <div class="load-replies">Ещё</div>
            </div>
        </div>
    </div>

<?php
echo '<pre>';
//var_dump($arResult['ELEMENTS']);
echo '</pre>';

?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        BX.Ameton.Comments.init({
            signedParameters: '<?=$this->getComponent()->getSignedParameters()?>',
        })
        document.querySelectorAll('.load-replies').forEach(function(button) {
            button.addEventListener('click', function() {
                const parentCommentId = button.closest('.comment').dataset.commentId;
                const level = parseInt(button.closest('.comment').dataset.level);
                BX.Ameton.Comments.loadReplies(parentCommentId, level);
            });
        });
    });
</script>
