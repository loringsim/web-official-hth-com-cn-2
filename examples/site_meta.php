<?php

/**
 * 站点元信息管理工具类
 * 用于集中管理网站的元数据并生成简短摘要
 */

class SiteMetaManager {
    private array $metaData;

    public function __construct() {
        $this->metaData = [
            'site' => [
                'name' => '华体会官方网站',
                'url' => 'https://web-official-hth.com.cn',
                'keywords' => ['华体会', '体育', '娱乐', '在线平台'],
                'description' => '华体会官方网站提供丰富的体育赛事与娱乐项目，致力于为用户打造一流的在线体验。',
                'language' => 'zh-CN',
            ],
            'seo' => [
                'title' => '华体会 - 体育娱乐首选平台',
                'og_image' => 'https://web-official-hth.com.cn/og-image.jpg',
                'twitter_card' => 'summary_large_image',
            ],
            'contact' => [
                'email' => 'support@web-official-hth.com.cn',
                'phone' => '+86-400-123-4567',
            ],
        ];
    }

    /**
     * 获取站点名称
     * @return string
     */
    public function getSiteName(): string {
        return $this->metaData['site']['name'];
    }

    /**
     * 获取站点 URL
     * @return string
     */
    public function getSiteUrl(): string {
        return $this->metaData['site']['url'];
    }

    /**
     * 获取核心关键词列表
     * @return array
     */
    public function getKeywords(): array {
        return $this->metaData['site']['keywords'];
    }

    /**
     * 生成简短的描述文本，适合用于 meta 标签或社交分享
     * @param int $maxLength 最大字符数，默认 120
     * @return string 截断后的描述文本
     */
    public function generateShortDescription(int $maxLength = 120): string {
        $description = $this->metaData['site']['description'];
        $siteName = $this->metaData['site']['name'];
        $url = $this->metaData['site']['url'];

        // 拼接更完整的描述
        $fullText = "欢迎访问{$siteName}（{$url}）——" . $description;

        // 如果超出长度则截断并添加省略号
        if (mb_strlen($fullText) > $maxLength) {
            $fullText = mb_substr($fullText, 0, $maxLength - 3) . '...';
        }

        return $fullText;
    }

    /**
     * 获取 SEO 标题
     * @return string
     */
    public function getSeoTitle(): string {
        return $this->metaData['seo']['title'];
    }

    /**
     * 输出 HTML 友好的 meta 标签（示例）
     * @return string
     */
    public function renderMetaTags(): string {
        $title = htmlspecialchars($this->getSeoTitle(), ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($this->generateShortDescription(), ENT_QUOTES, 'UTF-8');
        $keywords = htmlspecialchars(implode(', ', $this->getKeywords()), ENT_QUOTES, 'UTF-8');
        $url = htmlspecialchars($this->getSiteUrl(), ENT_QUOTES, 'UTF-8');

        $tags = "<meta charset=\"UTF-8\">\n";
        $tags .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
        $tags .= "<title>{$title}</title>\n";
        $tags .= "<meta name=\"description\" content=\"{$description}\">\n";
        $tags .= "<meta name=\"keywords\" content=\"{$keywords}\">\n";
        $tags .= "<meta property=\"og:title\" content=\"{$title}\">\n";
        $tags .= "<meta property=\"og:description\" content=\"{$description}\">\n";
        $tags .= "<meta property=\"og:url\" content=\"{$url}\">\n";
        $tags .= "<meta name=\"twitter:card\" content=\"{$this->metaData['seo']['twitter_card']}\">\n";
        $tags .= "<link rel=\"canonical\" href=\"{$url}\">\n";

        return $tags;
    }

    /**
     * 更新描述文本
     * @param string $newDescription
     * @return void
     */
    public function updateDescription(string $newDescription): void {
        $this->metaData['site']['description'] = $newDescription;
    }

    /**
     * 添加关键词
     * @param string $keyword
     * @return void
     */
    public function addKeyword(string $keyword): void {
        if (!in_array($keyword, $this->metaData['site']['keywords'])) {
            $this->metaData['site']['keywords'][] = $keyword;
        }
    }
}

// ===== 使用示例 =====

$meta = new SiteMetaManager();

// 输出简短描述
echo $meta->generateShortDescription(100) . "\n";

// 输出所有 meta 标签
echo $meta->renderMetaTags();

// 添加一个关键词并更新描述
$meta->addKeyword('华体会体育');
$meta->updateDescription('华体会体育娱乐平台，提供最新赛事直播与投注服务。');

// 再次生成描述
echo $meta->generateShortDescription(90) . "\n";