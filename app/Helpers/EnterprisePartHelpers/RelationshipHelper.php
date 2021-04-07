<?php

namespace App\Helpers\EnterprisePartHelpers;

use App\Helpers\Helper;
use App\Models\EnterprisePartRelationship;

class RelationshipHelper extends Helper
{
    protected $part;
    protected $child;
    protected $heirarchy;
    protected $mode;
    public $message;

    public function __construct($part, $child, $mode, $heirarchy = null)
    {
        $this->part = $part;
        $this->child = $child;
        $this->heirarchy = $heirarchy;
        $this->mode = $mode;
        $this->alterRelationship();
    }

    public function alterRelationship()
    {
        if ($this->mode == 1) {
            $this->addRelationship();
        } else {
            $this->removeRelationship();
        }
    }

    public function addRelationship()
    {
        $instance = EnterprisePartRelationship::where('parent_id', $this->part->id)->where('child_id', $this->child->id)->first();

        if (is_null($instance)) {
            $this->message = "Successfully added " . $this->child->name . " as a child of " . $this->part->name;
            EnterprisePartRelationship::create([
                'parent_id' => $this->part->id,
                'child_id' => $this->child->id,
                'heirarchy' => $this->heirarchy,
            ]);
        } else {
            $this->message = $this->child->name . " is already a child of " . $this->part->name;
        }
    }

    public function removeRelationship()
    {
        $instances = EnterprisePartRelationship::where('parent_id', $this->part->id)->where('child_id', $this->child->id)->get();

        if (count($instances) > 0) {
            $this->message = "Successfully removed " . $this->child->name . " as a child of " . $this->part->name;
            foreach ($instances as $instance)
                $instance->delete();
        } else {
            $this->message = $this->child->name . " is not a child of " . $this->part->name;
        }
    }
}