<?php

function formatCurrency($input)
{
    return 'Rp '.number_format((float)$input, 0, ',', '.');
}

function unformatCurrency($input)
{
    return str_replace(',', '.', str_replace('.', '', str_replace('Rp ', '', $input)));
}
