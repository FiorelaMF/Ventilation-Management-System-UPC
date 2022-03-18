<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/logging/v2/logging_config.proto

namespace Google\Logging\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The parameters to `UpdateExclusion`.
 *
 * Generated from protobuf message <code>google.logging.v2.UpdateExclusionRequest</code>
 */
class UpdateExclusionRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name of the exclusion to update:
     *     "projects/[PROJECT_ID]/exclusions/[EXCLUSION_ID]"
     *     "organizations/[ORGANIZATION_ID]/exclusions/[EXCLUSION_ID]"
     *     "billingAccounts/[BILLING_ACCOUNT_ID]/exclusions/[EXCLUSION_ID]"
     *     "folders/[FOLDER_ID]/exclusions/[EXCLUSION_ID]"
     * Example: `"projects/my-project-id/exclusions/my-exclusion-id"`.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    private $name = '';
    /**
     * Required. New values for the existing exclusion. Only the fields specified
     * in `update_mask` are relevant.
     *
     * Generated from protobuf field <code>.google.logging.v2.LogExclusion exclusion = 2;</code>
     */
    private $exclusion = null;
    /**
     * Required. A nonempty list of fields to change in the existing exclusion.
     * New values for the fields are taken from the corresponding fields in the
     * [LogExclusion][google.logging.v2.LogExclusion] included in this request. Fields not mentioned in
     * `update_mask` are not changed and are ignored in the request.
     * For example, to change the filter and description of an exclusion,
     * specify an `update_mask` of `"filter,description"`.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 3;</code>
     */
    private $update_mask = null;

    public function __construct() {
        \GPBMetadata\Google\Logging\V2\LoggingConfig::initOnce();
        parent::__construct();
    }

    /**
     * Required. The resource name of the exclusion to update:
     *     "projects/[PROJECT_ID]/exclusions/[EXCLUSION_ID]"
     *     "organizations/[ORGANIZATION_ID]/exclusions/[EXCLUSION_ID]"
     *     "billingAccounts/[BILLING_ACCOUNT_ID]/exclusions/[EXCLUSION_ID]"
     *     "folders/[FOLDER_ID]/exclusions/[EXCLUSION_ID]"
     * Example: `"projects/my-project-id/exclusions/my-exclusion-id"`.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The resource name of the exclusion to update:
     *     "projects/[PROJECT_ID]/exclusions/[EXCLUSION_ID]"
     *     "organizations/[ORGANIZATION_ID]/exclusions/[EXCLUSION_ID]"
     *     "billingAccounts/[BILLING_ACCOUNT_ID]/exclusions/[EXCLUSION_ID]"
     *     "folders/[FOLDER_ID]/exclusions/[EXCLUSION_ID]"
     * Example: `"projects/my-project-id/exclusions/my-exclusion-id"`.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Required. New values for the existing exclusion. Only the fields specified
     * in `update_mask` are relevant.
     *
     * Generated from protobuf field <code>.google.logging.v2.LogExclusion exclusion = 2;</code>
     * @return \Google\Logging\V2\LogExclusion
     */
    public function getExclusion()
    {
        return $this->exclusion;
    }

    /**
     * Required. New values for the existing exclusion. Only the fields specified
     * in `update_mask` are relevant.
     *
     * Generated from protobuf field <code>.google.logging.v2.LogExclusion exclusion = 2;</code>
     * @param \Google\Logging\V2\LogExclusion $var
     * @return $this
     */
    public function setExclusion($var)
    {
        GPBUtil::checkMessage($var, \Google\Logging\V2\LogExclusion::class);
        $this->exclusion = $var;

        return $this;
    }

    /**
     * Required. A nonempty list of fields to change in the existing exclusion.
     * New values for the fields are taken from the corresponding fields in the
     * [LogExclusion][google.logging.v2.LogExclusion] included in this request. Fields not mentioned in
     * `update_mask` are not changed and are ignored in the request.
     * For example, to change the filter and description of an exclusion,
     * specify an `update_mask` of `"filter,description"`.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 3;</code>
     * @return \Google\Protobuf\FieldMask
     */
    public function getUpdateMask()
    {
        return $this->update_mask;
    }

    /**
     * Required. A nonempty list of fields to change in the existing exclusion.
     * New values for the fields are taken from the corresponding fields in the
     * [LogExclusion][google.logging.v2.LogExclusion] included in this request. Fields not mentioned in
     * `update_mask` are not changed and are ignored in the request.
     * For example, to change the filter and description of an exclusion,
     * specify an `update_mask` of `"filter,description"`.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 3;</code>
     * @param \Google\Protobuf\FieldMask $var
     * @return $this
     */
    public function setUpdateMask($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\FieldMask::class);
        $this->update_mask = $var;

        return $this;
    }

}

