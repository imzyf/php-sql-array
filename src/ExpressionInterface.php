<?php

declare(strict_types=1);

namespace Yifans\QueryArray;

/**
 * Interface ExpressionInterface should be used to mark classes, that should be built
 * in a special way.
 *
 * The database abstraction layer of Yii framework supports objects that implement this
 * interface and will use [[ExpressionBuilderInterface]] to build them.
 *
 * The default implementation is a class [[Expression]].
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
interface ExpressionInterface
{
}