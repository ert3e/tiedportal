<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 16/02/2016
 * Time: 15:31
 */

namespace App\Classes;

use App\Models\Media;
use App\Models\Project;
use App\Models\Supplier;
use App\Models\Task;
use App\Models\Ticket;
use Carbon\Carbon;
use \Crypt;
use \File;

class FieldRenderer
{
    public function render($component_field_value) {

        $rendered = '';

        switch( $component_field_value->componentField->type ) {

            case 'password':
                $rendered = sprintf('%s: <strong>%s</strong>', $component_field_value->componentField->name, Crypt::decrypt($component_field_value->value));
                break;

            case 'text':
                $text = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?&_/]+!', '<a href="\\0" target="_blank">\\0</a>', $component_field_value->value);
                $rendered = sprintf('%s: <strong>%s</strong>', $component_field_value->componentField->name, nl2br($text));
                break;

            case 'longtext':
                $text = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?&_/]+!', '<a href="\\0" target="_blank">\\0</a>', $component_field_value->value);
                $rendered = sprintf('%s:<br/><strong>%s</strong>', $component_field_value->componentField->name, nl2br($text));
                break;

            case 'number':
                $rendered = sprintf('%s: <strong>%s</strong>', $component_field_value->componentField->name, number_format($component_field_value->value, 0));
                break;

            case 'decimal':
                $rendered = sprintf('%s: <strong>%s</strong>', $component_field_value->componentField->name, number_format($component_field_value->value, 1));
                break;

            case 'date':
                $date = Carbon::parse($component_field_value->value);
                $rendered = sprintf('%s: <strong>%s</strong>', $component_field_value->componentField->name, $date->format('d/m/Y'));
                break;

            case 'time':
                $rendered = sprintf('%s: <strong>%s</strong>', $component_field_value->componentField->name, $component_field_value->value);
                break;

            case 'datetime':
                $date = Carbon::parse($component_field_value->value);
                $rendered = sprintf('%s: <strong>%s</strong>', $component_field_value->componentField->name, $date->format('d/m/Y H:i'));
                break;

            case 'file':
                $media = Media::find(intval($component_field_value->value));
                $rendered = sprintf('<a href="%s" title="%s" target="_blank">Download %s</a>', route('media.download', $media->id, str_slug($media->name)), $media->name, $media->name);
                break;
        }

        return $rendered;
    }

    public function url($object) {
        $url = false;

        if( is_a($object, Project::class) ) {
            $url = route('projects.details', $object->id);
        } else if( is_a($object, Task::class) ) {
            $url = route('tasks.details', $object->id);
        } else if( is_a($object, Supplier::class) ) {
            $url = route('suppliers.details', $object->id);
        } else if( is_a($object, Contact::class) ) {
            $url = route('contacts.details', $object->id);
        }

        return $url;
    }

    public function formatDate($date, $with_time = false, $not_set = 'Not Set') {
        if( !is_object($date) || $date->format('Y') < 1980 )
            return $not_set;

        return $with_time ? $date->format('d/m/Y H:i') : $date->format('d/m/Y');
    }

    public function formatTime($date, $not_set = 'Not Set') {
        if( !is_object($date) || $date->format('Y') < 1980 )
            return $not_set;

        return $date->format('H:i');
    }

    public function formatCurrency($value, $prefix = '&pound;') {
        return sprintf('%s%s', $prefix, number_format(doubleval($value), 2));
    }

    public function decimal($value) {
        return number_format(doubleval($value), 2);
    }

    public function user($user, $not_set = 'Not Set') {

        if( !is_object($user) )
            return $not_set;

        if( is_object($user->contact) && strlen($user->contact->first_name) )
            return sprintf('<a href="%s">%s %s</a>', route('users.details', $user->id), $user->contact->first_name, $user->contact->last_name);

        return sprintf('<a href="%s">%s</a>', route('users.details', $user->id), $user->username);
    }

    public function userDisplay($user, $not_set = 'Not Set') {

        if( !is_object($user) )
            return $not_set;

        if( is_object($user->contact) && strlen($user->contact->first_name) )
            return sprintf('%s %s', $user->contact->first_name, $user->contact->last_name);

        return $user->username;
    }

    public function users($users) {

        if( count($users) ) {
            $user_links = [];
            foreach( $users as $user ) {
                if ($user->contact && $user->contact->first_name) {
                    $user_links[] = sprintf('<a href="%s">%s %s</a>', route('users.details', $user->id), $user->contact->first_name, $user->contact->last_name);
                } else {
                    $user_links[] = sprintf('<a href="%s">%s</a>', route('users.details', $user->id), $user->username);
                }
            }

            return implode(', ', $user_links);
        }

        return 'None';
    }

    public function projectDue($project) {

        $statuses = [];

        if( is_object($project->due_date) && $project->due_date->format('Y') > 1980 ) {
            $now = Carbon::now();
            $this_week = Carbon::now()->addDays(7);

            if( $project->due_date->lte($now) )
                $statuses[] = sprintf('<span class="label label-danger">Overdue</span>');
            else if( $project->due_date->isToday() )
                $statuses[] = sprintf('<span class="label label-primary">Due today</span>');
            else if( $project->due_date->lte($this_week) )
                $statuses[] = sprintf('<span class="label label-warning">Due soon</span>');
        }

        return implode(' ', $statuses);
    }

    public function dueDate($date) {

        $statuses = [];

        if( is_object($date) && $date->format('Y') > 1980 ) {

            $statuses[] = sprintf('<span>%s</span>', $date->format('d/m/Y'));

            $now = Carbon::now();
            $this_week = Carbon::now()->addDays(7);

            if( $date->lte($now) )
                $statuses[] = sprintf('<span class="label label-danger">Overdue</span>');
            else if( $date->isToday() )
                $statuses[] = sprintf('<span class="label label-primary">Due today</span>');
            else if( $date->lte($this_week) )
                $statuses[] = sprintf('<span class="label label-warning">Due soon</span>');
        }

        return implode(' ', $statuses);
    }

    public function projectStatus($project) {

        if( $project->status == 'prospect' ) {
            if (!is_object($project->prospectStatus)) {
                return 'N/A';
            }

            return $project->prospectStatus->name;
        } else {
            if (!is_object($project->projectStatus)) {
                return 'N/A';
            }

            return $project->projectStatus->name;
        }
    }

    public function display($value_object, $not_set = 'Not Set')
    {
        if( is_null($value_object) )
            return $not_set;

        if( is_string($value_object) )
            return $value_object;

        if( method_exists($value_object, 'displayName') )
            $text_value = $value_object->displayName();
        else if( property_exists($value_object, 'name') )
            $text_value = $value_object->name;

        $property_class = get_class($value_object);
        $traits = class_uses($property_class);

        if( in_array('App\AppTraits\HasColour', $traits) ) {
            $value = sprintf('<span class="label label-default" style="background-color: #%s">%s</span>', $value_object->colour, $text_value);
        } else {
            $value = $text_value;
        }

        return $value;
    }

    public function longtext($value) {

        return nl2br(Autolink::autolink($value, 0));
    }

    public function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function preview($media) {

        // Display a real preview if we have an image
        if( substr($media->mime_type, 0, 5) == 'image' ) {
            return route('media.get', [$media->id, 120, 120]);
        }

        $extension = strtolower(File::extension($media->name));

        $icon_path = public_path() . '/img/' . $extension . '.png';

        if( file_exists($icon_path) )
            return '/img/' . $extension . '.png';

        switch($extension) {

            case 'zip':
            case 'rar':
            case '7z':
                return '/img/icons/zip.png';

            case 'mp4':
            case 'm4v':
            case 'mkv':
            case 'ogg':
                return '/img/icons/video.png';

            case 'doc':
            case 'docx':
            case 'dot':
            case 'dotx':
                return '/img/icons/doc.png';

            case 'xls':
            case 'xlsx':
                return '/img/icons/xlsx.png';

            case 'pdf':
                return '/img/icons/pdf.png';

            case 'ttf':
            case 'woff':
            case 'otf':
                return '/img/icons/font.png';

            case 'mp3':
                return '/img/icons/mp3.png';

            case 'html':
                return '/img/icons/html.png';

            case 'ind':
            case 'indd':
                return '/img/icons/indd.png';

            case 'psd':
                return '/img/icons/psd.png';
        }

        return '/img/icons/unknown.png';
    }

    public function severity($severity) {
        return array_get(Ticket::$severity_levels, $severity, 'Unknown');
    }
}
