<?php

declare(strict_types=1);

namespace PoPSitesWassup\PostLinkMutations\MutationResolvers;

use PoPSitesWassup\PostMutations\MutationResolvers\AbstractCreateUpdatePostMutationResolver;
use PoPSitesWassup\CustomPostLinkMutations\MutationResolvers\MutationResolverUtils;

abstract class AbstractCreateUpdatePostLinkMutationResolver extends AbstractCreateUpdatePostMutationResolver
{
    protected function getCategories(array $form_data): ?array
    {
        $ret = parent::getCategories($form_data);
        $ret[] = \POP_CONTENTPOSTLINKS_CAT_CONTENTPOSTLINKS;
        return $ret;
    }

    protected function validateContent(array &$errors, array $form_data): void
    {
        parent::validateContent($errors, $form_data);
        MutationResolverUtils::validateContent($errors, $form_data);
    }

    protected function additionals(string | int $post_id, array $form_data): void
    {
        parent::additionals($post_id, $form_data);

        if (\PoP_ApplicationProcessors_Utils::addLinkAccesstype()) {
            \PoPSchema\CustomPostMeta\Utils::updateCustomPostMeta($post_id, GD_METAKEY_POST_LINKACCESS, $form_data['linkaccess'], true);
        }
    }
}
