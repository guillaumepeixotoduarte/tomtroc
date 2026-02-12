<?php
    $styleListConv = "d-flex";
    $styleConvContent = "d-none d-lg-flex";
    if(!empty($recipientUser)){
        $styleListConv = "d-none d-lg-flex";
        $styleConvContent = "d-flex";
    }
?>

<div class="min-screen-height">
    <div class="container-fluid m-0 d-flex flex-column main-bg-color px-0 px-lg-3 px-xl-5">
        <div class="row flex-grow-1 flex-nowrap h-100 px-0 px-lg-3 px-xl-5">
            <div class="col-lg-3 col-12 <?= $styleListConv ?> flex-column h-100">
                <div class="d-flex flex-column h-100 ms-0 ms-lg-2">
                    <div class="d-flex flex-column h-100 second-bg-color py-4">
                        <h3 class="ps-4 my-4">Messagerie</h3>
                        <div class="flex-grow-1 overflow-auto">
                            <?php if(!empty($conversations)): ?>
                                <?php foreach($conversations as $conversation): ?>
                                    <a class="d-flex w-100 px-4 border-bottom border-white text-black text-decoration-none py-3 <?= (!empty($activeId) && $activeId == $conversation->getId()) ? 'bg-white' : '' ?>" href="<?= url('messagerie/conversation/'.$conversation->getId()) ?>">
                                        <img class="profile-img-small rounded-circle me-3" src="<?= !empty($conversation->getContact()->getProfilImage()) ? getProfileImageUrl($conversation->getContact()->getProfilImage()) : url('img/default-profil-image.png') ?>">
                                        <div class="w-100 d-inline-grid ">
                                            <div class="d-flex justify-content-between mt-1">
                                                <span class="font-size-14 d-flex align-items-center">
                                                    <?= $conversation->getContact()->getUsername() ?>
                                                    <?php if( !empty($unreadConversation) && isset($unreadConversation[$conversation->getId()]) ):?>
                                                        <span class="unread-count ms-2"><?= $unreadConversation[$conversation->getId()] ?></span>
                                                    <?php endif; ?>
                                                </span>
                                                <span class="font-size-12 d-flex align-items-center"><?= $conversation->getLastMessage()->getChatTimestamp() ?></span>
                                            </div>
                                            <span class="text-truncate grey-text font-size-12 m-0"><?= $conversation->getLastMessage()->getContent() ?></span>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-12 py-4 <?= $styleConvContent ?> flex-column h-100" id="conversation-content">
                <div class="mx-xl-3 d-flex flex-column h-100 ">
                    <div class="ps-3 ps-md-4 ps-lg-0 pe-4 d-flex flex-column h-100 ">
                        <?php if(!empty($recipientUser)): ?>
                            <a class="d-block d-lg-none grey-text font-size-14 text-decoration-none mb-2" href="<?= url('messagerie') ?>"> <i class="bi bi-arrow-left"></i> retour </a>
                            <div class="chat-header">
                                <img src="<?= !empty($recipientUser->getProfilImage()) ? getProfileImageUrl($recipientUser->getProfilImage()) : url('img/default-profil-image.png') ?>" alt="Image de profil de <?= $recipientUser->getUsername() ?>" class="rounded-circle profile-img-small">
                                <span class="fw-semibold"><?= $recipientUser->getUsername() ?></span>
                            </div>

                            <div class="flex-grow-1 overflow-auto mt-3 mb-5 d-flex flex-column" id="chat-window">
                                <div class="mt-auto"></div>
                                <?php if(isset($messages) && !empty($messages)): ?>
                                    <?php foreach($messages as $message): ?>
                                        <?php if($message->getUserId() == $_SESSION['user']['id']): ?>
                                            <div class="d-flex flex-column">
                                                <p class="font-size-12 grey-text text-end mb-1"><?= $message->getFullTimestamp() ?></p>
                                                <p class="d-inline-flex ms-auto light-blue-bg-color py-2 px-3 message-content rounded">
                                                    <?= $message->getContent() ?>
                                                </p>
                                            </div>
                                        <?php else: ?>
                                            <div class="d-flex flex-column">
                                                <div class="mb-1 d-inline-flex flex-row align-items-center">
                                                    <img src="<?= !empty($recipientUser->getProfilImage()) ? getProfileImageUrl($recipientUser->getProfilImage()) : url('img/default-profil-image.png') ?>" alt="Image de profil de <?= $recipientUser->getUsername() ?>" class="rounded-circle profile-img-xs">
                                                    <p class="font-size-12 grey-text mb-0"><?= $message->getFullTimestamp() ?></p>
                                                </div>
                                                <p class="d-inline-flex bg-white py-2 px-3 message-content rounded">
                                                    <?= $message->getContent() ?>
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <?php if(isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger mb-3"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                            <?php endif; ?>
                            <form class="d-flex flex-column flex-md-row pt-3" method="POST" action="<?= url('messagerie/envoi') ?>">
                                <input type="text" class="form-control px-3 px-lg-5 py-3 border-0 grey-placeholder mb-3 mb-md-0 mx-0 ms-md-2 me-md-4" name="messageContent" placeholder="Tapez votre message ici" required>
                                <input type="hidden" name="recipientId" value="<?= $recipientUser->getId() ?>">
                                <input type="submit" class="classic-button green-button">
                            </form>
                        <?php else: ?>
                            <div class="flex-grow-1 overflow-auto mt-3 mb-5">
                                
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>