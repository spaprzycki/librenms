<?php

require 'elastica-loader.php';

// Time range for lookup
$time = array('from' => 'now-5m', 'to' => 'now');

// Setting time sub-filter
$timeRange = new \Elastica\Filter\Range();
$timeRange->addField('@timestamp', $time);

// Setting exclude 0.0.0.0 sub-filter
$ipTerm = new \Elastica\Filter\Term();
$ipTerm->setTerm('ip_dst', '0.0.0.0');

// Setting bool filter
$boolFilter = new \Elastica\Filter\Bool();

// Add sub-filters to bool filter
$boolFilter->addMust($timeRange);
$boolFilter->addMustNot($ipTerm);

// Create filtered query
$filteredQuery = new \Elastica\Query\Filtered();

// Add bool filter to filtered query
$filteredQuery->setFilter($boolFilter);

// Create query from filtered query
$query = new \Elastica\Query($filteredQuery);

// Set requested result size to 0
$query->setSize('0');

// Set main aggregation
$terms = new \Elastica\Aggregation\Terms('terms');

// Set pps sub-aggragation
$pktsSum = new \Elastica\Aggregation\Sum('packets-sum');
$pktsSum->setField('packets');
$pktsSum->setScript('_value/300');

// Set mbps sub-aggragation
$mbpsSum = new \Elastica\Aggregation\Sum('mbps-sum');
$mbpsSum->setField('bytes');
$mbpsSum->setScript('_value/37500000');

// Set requested aggregation field, size and order of aggregation
$terms->setField('ip_dst');
$terms->setSize('5');
$terms->setOrder('packets-sum', 'desc');

// Add sub-aggregations
$terms->addAggregation($pktsSum);
$terms->addAggregation($mbpsSum);

// Add aggregation to query
$query->addAggregation($terms);

// Create client connection to localhost elasticsearch
$client = new \Elastica\Client();

// Set index
$index = $client->getIndex('logstash-2015.09.17');

// Execute query
$result = $index->search($query);

// Print aggregation
print_r($result->getAggregations());
