<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Model\Image;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Model FileInfo
 */
class FileInfo
{
    /**
     * Path in /pub/media directory
     */
    const ENTITY_MEDIA_PATH = '/healthyvibes/moneymanagement';

    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    /**
     * @var Mime
     */
    private Mime $mime;

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var ReadInterface
     */
    private ReadInterface $baseDirectory;

    /**
     * @var ReadInterface
     */
    private ReadInterface $pubDirectory;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @param Filesystem $filesystem
     * @param Mime $mime
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Filesystem $filesystem,
        Mime $mime,
        StoreManagerInterface $storeManager
    ) {
        $this->filesystem = $filesystem;
        $this->mime = $mime;
        $this->storeManager = $storeManager;
    }

    /**
     * Get WriteInterface instance
     *
     * @return WriteInterface
     * @throws FileSystemException
     */
    private function getMediaDirectory()
    {
        if ($this->mediaDirectory === null) {
            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        }
        return $this->mediaDirectory;
    }

    /**
     * Get Base Directory read instance
     *
     * @return ReadInterface
     */
    private function getBaseDirectory()
    {
        if (!isset($this->baseDirectory)) {
            $this->baseDirectory = $this->filesystem->getDirectoryRead(DirectoryList::ROOT);
        }

        return $this->baseDirectory;
    }

    /**
     * Get Pub Directory read instance
     *
     * @return ReadInterface
     */
    private function getPubDirectory()
    {
        if (!isset($this->pubDirectory)) {
            $this->pubDirectory = $this->filesystem->getDirectoryRead(DirectoryList::PUB);
        }

        return $this->pubDirectory;
    }

    /**
     * Retrieve MIME type of requested file
     *
     * @param string $fileName
     * @return string
     * @throws FileSystemException
     */
    public function getMimeType($fileName)
    {
        $filePath = $this->getFilePath($fileName);
        $absoluteFilePath = $this->getMediaDirectory()->getAbsolutePath($filePath);

        return $this->mime->getMimeType($absoluteFilePath);
    }

    /**
     * Get file statistics data
     *
     * @param string $fileName
     * @return array
     * @throws FileSystemException
     */
    public function getStat($fileName)
    {
        $filePath = $this->getFilePath($fileName);

        return $this->getMediaDirectory()->stat($filePath);
    }

    /**
     * Check if the file exists
     *
     * @param string $fileName
     * @return bool
     * @throws FileSystemException
     */
    public function isExist($fileName)
    {
        $filePath = $this->getFilePath($fileName);

        return $this->getMediaDirectory()->isExist($filePath);
    }

    /**
     * Construct and return file subpath based on filename relative to media directory
     *
     * @param string $fileName
     * @return string
     * @throws FileSystemException
     */
    private function getFilePath($fileName)
    {
        $filePath = $this->removeStorePath($fileName);
        $filePath = ltrim($filePath, '/');

        $mediaDirectoryRelativeSubpath = $this->getMediaDirectoryPathRelativeToBaseDirectoryPath($filePath);
        $isFileNameBeginsWithMediaDirectoryPath = $this->isBeginsWithMediaDirectoryPath($fileName);

        // if the file is not using a relative path, it resides in the catalog/category media directory
        $fileIsInCategoryMediaDir = !$isFileNameBeginsWithMediaDirectoryPath;

        if ($fileIsInCategoryMediaDir) {
            $filePath = self::ENTITY_MEDIA_PATH . '/' . $filePath;
        } else {
            $filePath = substr($filePath, strlen($mediaDirectoryRelativeSubpath));
        }

        return $filePath;
    }

    /**
     * Checks for whether $fileName string begins with media directory path
     *
     * @param string $fileName
     * @return bool
     * @throws FileSystemException
     */
    public function isBeginsWithMediaDirectoryPath($fileName)
    {
        $filePath = $this->removeStorePath($fileName);
        $filePath = ltrim($filePath, '/');

        $mediaDirectoryRelativeSubpath = $this->getMediaDirectoryPathRelativeToBaseDirectoryPath($filePath);
        return strpos($filePath, (string)$mediaDirectoryRelativeSubpath) === 0;
    }

    /**
     * Clean store path in case if it's exists
     *
     * @param string $path
     * @return string
     */
    private function removeStorePath(string $path): string
    {
        $result = $path;
        try {
            $storeUrl = $this->storeManager->getStore()->getBaseUrl();
        } catch (NoSuchEntityException $e) {
            return $result;
        }
        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        $path = parse_url($path, PHP_URL_PATH);
        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        $storePath = parse_url($storeUrl, PHP_URL_PATH);
        $storePath = rtrim($storePath, '/');

        return preg_replace('/^' . preg_quote($storePath, '/') . '/', '', $path);
    }

    /**
     * Get media directory subpath relative to base directory path
     *
     * @param string $filePath
     * @return string
     * @throws FileSystemException
     */
    private function getMediaDirectoryPathRelativeToBaseDirectoryPath(string $filePath = '')
    {
        $baseDirectory = $this->getBaseDirectory();
        $baseDirectoryPath = $baseDirectory->getAbsolutePath();
        $mediaDirectoryPath = $this->getMediaDirectory()->getAbsolutePath();
        $pubDirectoryPath = $this->getPubDirectory()->getAbsolutePath();

        $mediaDirectoryRelativeSubpath = substr($mediaDirectoryPath, strlen($baseDirectoryPath));
        $pubDirectory = $baseDirectory->getRelativePath($pubDirectoryPath);

        if (strpos($mediaDirectoryRelativeSubpath, $pubDirectory) === 0 && strpos($filePath, $pubDirectory) !== 0) {
            $mediaDirectoryRelativeSubpath = substr($mediaDirectoryRelativeSubpath, strlen($pubDirectory));
        }

        return $mediaDirectoryRelativeSubpath;
    }
}
