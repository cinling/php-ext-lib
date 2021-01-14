<?php


namespace cin\extLib\traits;


use ReflectionClass;

/**
 * Trait ReflectTrait 反射帮助类
 * @package cin\extLib\traits
 *
 * @see https://www.coder.work/article/898745 代码来源
 */
trait ReflectTrait {
    /**
     * @var array Constant names to DocComment strings.
     */
    private $docComments = [];

    /**
     * Constructor.
     * @param $clazz
     * @throws \ReflectionException
     */
    public function __construct($clazz)
    {
        $this->parse(new ReflectionClass($clazz));
    }

    /**
     * Parses the class for constant DocComments.
     * @param ReflectionClass $clazz
     */
    private function parse(ReflectionClass $clazz)
    {
        $content = file_get_contents($clazz->getFileName());
        $tokens = token_get_all($content);

        $doc = null;
        $isConst = false;
        foreach($tokens as $token)
        {
            if (!is_array($token) || count($token) <= 1)
            {
                continue;
            }

            list($tokenType, $tokenValue) = $token;

            switch ($tokenType)
            {
                // ignored tokens
                case T_WHITESPACE:
                case T_COMMENT:
                    break;

                case T_DOC_COMMENT:
                    $doc = $tokenValue;
                    break;

                case T_CONST:
                    $isConst = true;
                    break;

                case T_STRING:
                    if ($isConst)
                    {
                        $this->docComments[$tokenValue] = self::clean($doc);
                    }
                    $doc = null;
                    $isConst = false;
                    break;

                // all other tokens reset the parser
                default:
                    $doc = null;
                    $isConst = false;
                    break;
            }
        }
    }

    /**
     * Returns an array of all constants to their DocComment. If no comment is present the comment is null.
     */
    public function getDocComments()
    {
        return $this->docComments;
    }

    /**
     * Returns the DocComment of a class constant. Null if the constant has no DocComment or the constant does not exist.
     * @param $constantName
     * @return mixed|null
     */
    public function getDocComment($constantName)
    {
        if (!isset($this->docComments) || !isset($this->docComments[$constantName]))
        {
            return null;
        }

        return $this->docComments[$constantName];
    }

    /**
     * Cleans the doc comment. Returns null if the doc comment is null.
     * @param $doc
     * @return string|null
     */
    private static function clean($doc)
    {
        if ($doc === null)
        {
            return null;
        }

        $result = null;
        $lines = preg_split('/\R/', $doc);
        foreach($lines as $line)
        {
            $line = trim($line, "/* \t\x0B\0");
            if ($line === '')
            {
                continue;
            }

            if ($result != null)
            {
                $result .= ' ';
            }
            $result .= $line;
        }
        return $result;
    }
}