<?php

namespace MMA\CustomApi\Api\Data;

interface RatingInterface
{
    /**
     * Get the rating_id field.
     *
     * @api
     * @return int The name field.
     */
    public function getRatingId();

    /**
     * Set the rating_id field.
     *
     * @api
     * @param $value int The new name field.
     * @return null
     */
    public function setRatingId($value);


    /**
     * Get the rating code field.
     *
     * @api
     * @return string The province field.
     */
    public function getRatingCode();

    /**
     * Set the rating code field.
     *
     * @api
     * @param $value string The new province field.
     * @return null
     */
    public function setRatingCode($value);

    /**
     * Get the rating value field.
     *
     * @api
     * @return int The name field.
     */
    public function getRatingValue();

    /**
     * Set the rating value field.
     *
     * @api
     * @param $value int The new name field.
     * @return null
     */
    public function setRatingValue($value);

}