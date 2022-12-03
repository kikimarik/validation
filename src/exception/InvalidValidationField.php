<?php

namespace kikimarik\validation\exception;

use kikimarik\validation\contract\ValidationRuntimeException;
use RuntimeException;

final class InvalidValidationField extends RuntimeException implements ValidationRuntimeException
{
}
