<?php


namespace cwreden\php7ccAnalyser;


class Parser
{
    /**
     * @param ScanResultFile $scanResultFile
     * @return Scan
     * @throws ScanResultParsingException
     */
    public function parse(ScanResultFile $scanResultFile)
    {
        $result = $scanResultFile->getResult();

        $this->ensureResultData($result);

        $summary = new Summary(
            $result['summary']['checkedFiles']
        );

        $scannedFileCollection = new ScannedSourceFileCollection();
        foreach ($result['files'] as $file) {
            $this->ensureFile($file);

            $warningIssueCollection = new IssueCollection();
            $errorIssueCollection = new IssueCollection();

            foreach ($file['warnings'] as $warning) {
                $this->ensureWarning($warning);
                $warningIssueCollection->add(new Issue((int)$warning['line'], $warning['text']));
            }

            foreach ($file['errors'] as $error) {
                $this->ensureError($error);
                $errorIssueCollection->add(new Issue((int)$error['line'], $error['text']));
            }

            $scannedFileCollection->add(new ScannedSourceFile(
                $file['name'],
                $warningIssueCollection,
                $errorIssueCollection
            ));
        }

        return new Scan($summary, $scannedFileCollection);
    }

    /**
     * @param $result
     * @throws ScanResultParsingException
     */
    private function ensureResultData($result)
    {
        if (!array_key_exists('summary', $result)) {
            throw new ScanResultParsingException('Missing attribute "summary".');
        }
        if (!array_key_exists('checkedFiles', $result['summary'])) {
            throw new ScanResultParsingException('Missing attribute "checkedFiles" under "summary".');
        }
        if (!array_key_exists('files', $result)) {
            throw new ScanResultParsingException('Missing attribute "files".');
        }
    }

    /**
     * @param $file
     * @throws ScanResultParsingException
     */
    private function ensureFile($file)
    {
        if (!array_key_exists('name', $file)) {
            throw new ScanResultParsingException('Missing attribute "name" at files.');
        }
        if (!array_key_exists('warnings', $file)) {
            throw new ScanResultParsingException(sprintf(
                'Missing attribute "warnings" at file %s.',
                $file['name']
            ));
        }
        if (!array_key_exists('errors', $file)) {
            throw new ScanResultParsingException(sprintf(
                'Missing attribute "errors" at file %s.',
                $file['name']
            ));
        }
    }

    /**
     * @param $warning
     * @throws ScanResultParsingException
     */
    private function ensureWarning($warning)
    {
        if (!array_key_exists('line', $warning)) {
            throw new ScanResultParsingException('Missing attribute "line" at warning.');
        }
        if (!array_key_exists('text', $warning)) {
            throw new ScanResultParsingException('Missing attribute "text" at warning.');
        }
    }

    /**
     * @param $error
     * @throws ScanResultParsingException
     */
    private function ensureError($error)
    {
        if (!array_key_exists('line', $error)) {
            throw new ScanResultParsingException('Missing attribute "line" at error.');
        }
        if (!array_key_exists('text', $error)) {
            throw new ScanResultParsingException('Missing attribute "text" at error.');
        }
    }
}