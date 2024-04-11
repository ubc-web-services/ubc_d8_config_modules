<?php

use Symfony\Component\Yaml\Yaml;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;

/**
 * @file
 * Post update hook is used when module is already enabled and you need to add or change config
 */

/**
 * add Envoke block and related configuration
 *
 */
function ubc_custom_block_types_post_update_add_envoke_block() {
  $module_path = \Drupal::service('extension.list.module')->getPath('ubc_custom_block_types');

  $config_path = $module_path . "/config/install/block_content.type.envoke_signup_form.yml";
  $data = Yaml::parseFile($config_path);
  \Drupal::logger('ubc_custom_block_types')->info("data: " . $config_path . " " . print_r($data, true));
  \Drupal::service('config.factory')->getEditable("block_content.type.envoke_signup_form")->setData($data)->save(TRUE);

  $config_path = $module_path . "/config/install/core.entity_form_display.block_content.envoke_signup_form.default.yml";
  $data = Yaml::parseFile($config_path);
  \Drupal::logger('ubc_custom_block_types')->info("data: " . $config_path . " " . print_r($data, true));
  \Drupal::service('config.factory')->getEditable("core.entity_form_display.block_content.envoke_signup_form.default")->setData($data)->save(TRUE);

  $config_path = $module_path . "/config/install/core.entity_view_display.block_content.envoke_signup_form.default.yml";
  $data = Yaml::parseFile($config_path);
  \Drupal::logger('ubc_custom_block_types')->info("data: " . $config_path . " " . print_r($data, true));
  \Drupal::service('config.factory')->getEditable("core.entity_view_display.block_content.envoke_signup_form.default")->setData($data)->save(TRUE);

  $yml = Yaml::parse(file_get_contents($module_path . '/config/install/field.storage.block_content.field_envoke_form_id.yml'));
  if (! FieldStorageConfig::loadByName($yml['entity_type'], $yml['field_name'])) {
    FieldStorageConfig::create($yml)->save();
    \Drupal::logger('ubc_custom_block_types')->info("field created");
  } else {
    \Drupal::logger('ubc_custom_block_types')->info("field NOT created");
  }

  $yml = Yaml::parse(file_get_contents($module_path . '/config/install/field.field.block_content.envoke_signup_form.field_envoke_form_id.yml'));
  if (! FieldConfig::loadByName($yml['entity_type'], $yml['bundle'], $yml['field_name'])) {
    FieldConfig::create($yml)->save();
    \Drupal::logger('ubc_custom_block_types')->info("field created");
  } else {
    \Drupal::logger('ubc_custom_block_types')->info("field NOT created");
  }

  $config_path = $module_path . "/config/install/field.field.block_content.envoke_signup_form.field_envoke_form_id.yml";
  $data = Yaml::parseFile($config_path);
  \Drupal::logger('ubc_custom_block_types')->info("data: " . $config_path . " " . print_r($data, true));
  \Drupal::service('config.factory')->getEditable("field.field.block_content.envoke_signup_form.field_envoke_form_id")->setData($data)->save(TRUE);

  $config_path = $module_path . "/config/install/field.storage.block_content.field_envoke_form_id.yml";
  $data = Yaml::parseFile($config_path);
  \Drupal::logger('ubc_custom_block_types')->info("data: " . $config_path . " " . print_r($data, true));
  \Drupal::service('config.factory')->getEditable("field.storage.block_content.field_envoke_form_id")->setData($data)->save(TRUE);

  \Drupal::logger('ubc_custom_block_types')->info("post update hook ran");
}
