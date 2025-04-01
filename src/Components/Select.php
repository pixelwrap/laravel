<?php

namespace PixelWrap\Laravel\Components;

class Select extends InputContract
{
    public bool $showLabel = true;
    public bool $required = true;
    public array $options = [];

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);

        if (isset($this->node->options)) {
            $this->setOptions($this->node->options);
        } elseif (isset($this->node->optionsMap)) {
            $map = $this->node->optionsMap;
            $options = [];
            if (isset($map->dataset)) {
                $datasetName = $map->dataset;
                if (isset($data[$datasetName])) {
                    $dataset = $data[$datasetName];
                    $dataset = $data[$map->dataset];
                    if (isset($map->key)) {
                        $key = $map->key;
                        if (isset($map->label)) {
                            $label = $map->label;
                            foreach ($dataset as $row) {
                                $obj = (object) $row;
                                if (isset($obj->{$key}) && isset($obj->{$label})) {
                                    $options[$obj->{$key}] = $obj->{$label};
                                } else {
                                    $this->errors[] = sprintf(
                                        "The label and key defined in optionsMap is required in your dataset records (%s)",
                                        $map->dataset
                                    );
                                }
                            }
                            $this->setOptions($options);
                        } else {
                            $this->errors[] = "A label is required when optionsMap is set";
                        }
                    } else {
                        $this->errors[] = "A key is required when optionsMap is set";
                    }
                } else {
                    $context = collect($data)->keys()->map(fn($k) => "'{$k}'")->toArray();
                    $this->errors[] = sprintf("Dataset '%s' not found in context. Found %s.", $datasetName, implode(", ", $context));
                }
            } else {
                $this->errors[] = "A dataset is required when optionsMap is set";
            }
            $this->setOptions($options);
        } else {
            $this->errors[] = "One of options or optionsMap must be set";
        }

        $this->addClass("block my-1 text-sm font-medium text-gray-800 dark:text-gray-50", "labelClasses");
        $this->addClass("h-5 w-5 ml-1 absolute top-2.5 right-2.5 text-slate-700 dark:text-gray-300", "caretClasses");
        $this->addClass($this->roundClasses);
        $this->addClass(
            "w-full bg-transparent text-gray-700 dark:text-gray-200 text-sm border border-gray-600 dark:border-gray-400 pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-gray-400 dark:focus:border-gray-300 hover:border-gray-400 dark:hover:border-gray-300 shadow-sm focus:shadow-md appearance-none cursor-pointer dark:bg-gray-800"
        );

        if ($node->disabled ?? false) {
            $this->addClass("disabled:opacity-50 cursor-not-allowed bg-gray-100");
        }
    }

    public function setOptions($options): void
    {
        foreach ($options as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value);
            }
            if (is_array($key) || is_object($key)) {
                $key = json_encode($key);
            }
            $this->options[$key] = $value;
        }
    }
}
