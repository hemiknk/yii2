<?php

namespace app\models\tables;

/**
 * This is the ActiveQuery class for [[Mailing]].
 *
 * @see Mailing
 */
class MailingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Mailing[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Mailing|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
