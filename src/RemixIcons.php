<?php

namespace Filafly\Icons\Remix;

use Filafly\Icons\IconSet;
use Filafly\Icons\Remix\Enums\Remix;
use Filafly\Icons\Remix\Enums\RemixStyle;
use Filament\Support\Icons\IconManager;

class RemixIcons extends IconSet
{
    protected string $pluginId = 'filafly-filament-remix-icons';

    protected mixed $iconEnum = Remix::class;

    protected string $iconPrefix = 'ri';

    protected mixed $styleEnum = RemixStyle::class;

    /** Line is the default, so style overrides work without calling line() first. */
    protected mixed $currentStyle = RemixStyle::Line;

    public function __construct()
    {
        if (method_exists(parent::class, '__construct')) {
            parent::__construct();
        }

        // Filament 4.2+ renames the 4.0 and 4.1 tables:: query builder keys to query-builder::
        // when they're registered. Registering both would let the legacy key overwrite
        // an overrideAlias() on the current one, so keep a legacy key only where
        // Filament still treats it as its own alias.
        if (! method_exists(IconManager::class, 'normalizeAlias')) {
            return;
        }

        foreach (array_keys($this->iconMap) as $alias) {
            $normalized = IconManager::normalizeAlias($alias);

            if ($normalized !== $alias && array_key_exists($normalized, $this->iconMap)) {
                unset($this->iconMap[$alias]);
            }
        }
    }

    /**
     * Every Filament 4 and 5 icon alias, mapped to a Remix icon.
     *
     * Keys are the alias strings rather than the *IconAlias constants, because
     * several constants (rich editor toolbar, multi-factor auth, callouts, query
     * builder) only exist in later 4.x releases. String keys keep the map loadable
     * on every Filament version the package supports.
     *
     * Icons with line and fill versions are mapped to the line version, so fill()
     * and the style overrides can switch them. Editor icons such as bold have a
     * single version and stay the same in both styles.
     */
    protected array $iconMap = [
        // Panels
        'panels::auth.multi-factor.app.actions.disable' => Remix::ShieldCrossLine,
        'panels::auth.multi-factor.app.actions.disable.modal' => Remix::ShieldCrossLine,
        'panels::auth.multi-factor.app.actions.disable.notification' => Remix::ShieldCrossLine,
        'panels::auth.multi-factor.app.actions.regenerate-recovery-codes' => Remix::RefreshLine,
        'panels::auth.multi-factor.app.actions.regenerate-recovery-codes.modal' => Remix::RefreshLine,
        'panels::auth.multi-factor.app.actions.regenerate-recovery-codes.notification' => Remix::Key2Line,
        'panels::auth.multi-factor.app.actions.set-up' => Remix::ShieldCheckLine,
        'panels::auth.multi-factor.app.actions.set-up.modal' => Remix::ShieldCheckLine,
        'panels::auth.multi-factor.app.actions.set-up.notification' => Remix::ShieldCheckLine,
        'panels::auth.multi-factor.email.actions.disable' => Remix::MailCloseLine,
        'panels::auth.multi-factor.email.actions.disable.modal' => Remix::MailCloseLine,
        'panels::auth.multi-factor.email.actions.disable.notification' => Remix::MailCloseLine,
        'panels::auth.multi-factor.email.actions.set-up' => Remix::MailCheckLine,
        'panels::auth.multi-factor.email.actions.set-up.modal' => Remix::MailCheckLine,
        'panels::auth.multi-factor.email.actions.set-up.notification' => Remix::MailCheckLine,
        'panels::global-search.field' => Remix::SearchLine,
        'panels::pages.dashboard.actions.filter' => Remix::Filter3Line,
        'panels::pages.dashboard.navigation-item' => Remix::Home5Line,
        'panels::pages.password-reset.request-password-reset.actions.login' => Remix::ArrowLeftLine,
        'panels::pages.password-reset.request-password-reset.actions.login.rtl' => Remix::ArrowRightLine,
        'panels::resources.pages.edit-record.navigation-item' => Remix::EditBoxLine,
        'panels::resources.pages.manage-related-records.navigation-item' => Remix::LayoutGridLine,
        'panels::resources.pages.view-record.navigation-item' => Remix::EyeLine,
        'panels::sidebar.collapse-button' => Remix::ArrowLeftSLine,
        'panels::sidebar.collapse-button.rtl' => Remix::ArrowRightSLine,
        'panels::sidebar.expand-button' => Remix::ArrowRightSLine,
        'panels::sidebar.expand-button.rtl' => Remix::ArrowLeftSLine,
        'panels::sidebar.group.collapse-button' => Remix::ArrowUpSLine,
        'panels::sidebar.open-database-notifications-button' => Remix::Notification3Line,
        'panels::sub-navigation.mobile-menu.button' => Remix::ArrowDownSLine,
        'panels::tenant-menu.billing-button' => Remix::BankCardLine,
        'panels::tenant-menu.profile-button' => Remix::Settings3Line,
        'panels::tenant-menu.registration-button' => Remix::AddLine,
        'panels::tenant-menu.toggle-button' => Remix::ExpandUpDownLine,
        'panels::theme-switcher.dark-button' => Remix::MoonLine,
        'panels::theme-switcher.light-button' => Remix::SunLine,
        'panels::theme-switcher.system-button' => Remix::ComputerLine,
        'panels::topbar.close-sidebar-button' => Remix::CloseLine,
        'panels::topbar.group.toggle-button' => Remix::ArrowDownSLine,
        'panels::topbar.open-database-notifications-button' => Remix::Notification3Line,
        'panels::topbar.open-sidebar-button' => Remix::MenuLine,
        'panels::user-menu.logout-button' => Remix::LogoutBoxRLine,
        'panels::user-menu.profile-item' => Remix::AccountCircleLine,
        'panels::user-menu.toggle-button' => Remix::ArrowDownSLine,
        'panels::widgets.account.logout-button' => Remix::LogoutBoxRLine,
        'panels::widgets.filament-info.open-documentation-button' => Remix::BookOpenLine,
        'panels::widgets.filament-info.open-github-button' => Remix::GithubLine,

        // Actions
        'actions::action-group' => Remix::More2Line,
        'actions::create-action.grouped' => Remix::AddLine,
        'actions::delete-action' => Remix::DeleteBinLine,
        'actions::delete-action.grouped' => Remix::DeleteBinLine,
        'actions::delete-action.modal' => Remix::DeleteBinLine,
        'actions::detach-action' => Remix::LinkUnlink,
        'actions::detach-action.modal' => Remix::LinkUnlink,
        'actions::dissociate-action' => Remix::LinkUnlink,
        'actions::dissociate-action.modal' => Remix::LinkUnlink,
        'actions::edit-action' => Remix::EditBoxLine,
        'actions::edit-action.grouped' => Remix::EditBoxLine,
        'actions::export-action.grouped' => Remix::DownloadLine,
        'actions::force-delete-action' => Remix::DeleteBinLine,
        'actions::force-delete-action.grouped' => Remix::DeleteBinLine,
        'actions::force-delete-action.modal' => Remix::DeleteBinLine,
        'actions::import-action.grouped' => Remix::UploadLine,
        'actions::modal.confirmation' => Remix::ErrorWarningLine,
        'actions::replicate-action' => Remix::FileCopyLine,
        'actions::replicate-action.grouped' => Remix::FileCopyLine,
        'actions::restore-action' => Remix::ArrowGoBackLine,
        'actions::restore-action.grouped' => Remix::ArrowGoBackLine,
        'actions::restore-action.modal' => Remix::ArrowGoBackLine,
        'actions::view-action' => Remix::EyeLine,
        'actions::view-action.grouped' => Remix::EyeLine,

        // Forms
        'forms::components.builder.actions.clone' => Remix::FileCopyLine,
        'forms::components.builder.actions.collapse' => Remix::ArrowUpSLine,
        'forms::components.builder.actions.delete' => Remix::DeleteBinLine,
        'forms::components.builder.actions.edit' => Remix::EditBoxLine,
        'forms::components.builder.actions.expand' => Remix::ArrowDownSLine,
        'forms::components.builder.actions.move-down' => Remix::ArrowDownLine,
        'forms::components.builder.actions.move-up' => Remix::ArrowUpLine,
        'forms::components.builder.actions.reorder' => Remix::Draggable,
        'forms::components.checkbox-list.search-field' => Remix::SearchLine,
        'forms::components.file-upload.editor.actions.drag-crop' => Remix::CropLine,
        'forms::components.file-upload.editor.actions.drag-move' => Remix::DragMove2Line,
        'forms::components.file-upload.editor.actions.flip-horizontal' => Remix::FlipHorizontalLine,
        'forms::components.file-upload.editor.actions.flip-vertical' => Remix::FlipVerticalLine,
        'forms::components.file-upload.editor.actions.move-down' => Remix::ArrowDownCircleLine,
        'forms::components.file-upload.editor.actions.move-left' => Remix::ArrowLeftCircleLine,
        'forms::components.file-upload.editor.actions.move-right' => Remix::ArrowRightCircleLine,
        'forms::components.file-upload.editor.actions.move-up' => Remix::ArrowUpCircleLine,
        'forms::components.file-upload.editor.actions.rotate-left' => Remix::AnticlockwiseLine,
        'forms::components.file-upload.editor.actions.rotate-right' => Remix::ClockwiseLine,
        'forms::components.file-upload.editor.actions.zoom-100' => Remix::CollapseDiagonalLine,
        'forms::components.file-upload.editor.actions.zoom-in' => Remix::ZoomInLine,
        'forms::components.file-upload.editor.actions.zoom-out' => Remix::ZoomOutLine,
        'forms::components.key-value.actions.delete' => Remix::DeleteBinLine,
        'forms::components.key-value.actions.reorder' => Remix::Draggable,
        'forms::components.modal-table-select.actions.select' => Remix::CursorLine,
        'forms::components.repeater.actions.clone' => Remix::FileCopyLine,
        'forms::components.repeater.actions.collapse' => Remix::ArrowUpSLine,
        'forms::components.repeater.actions.delete' => Remix::DeleteBinLine,
        'forms::components.repeater.actions.expand' => Remix::ArrowDownSLine,
        'forms::components.repeater.actions.move-down' => Remix::ArrowDownLine,
        'forms::components.repeater.actions.move-up' => Remix::ArrowUpLine,
        'forms::components.repeater.actions.reorder' => Remix::Draggable,
        'forms::components.rich-editor.panels.custom-block.delete-button' => Remix::DeleteBinLine,
        'forms::components.rich-editor.panels.custom-block.edit-button' => Remix::EditBoxLine,
        'forms::components.rich-editor.panels.custom-blocks.close-button' => Remix::CloseLine,
        'forms::components.rich-editor.panels.merge-tags.close-button' => Remix::CloseLine,
        'forms::components.select.actions.create-option' => Remix::AddLine,
        'forms::components.select.actions.edit-option' => Remix::EditBoxLine,
        'forms::components.text-input.actions.copy' => Remix::FileCopyLine,
        'forms::components.text-input.actions.hide-password' => Remix::EyeOffLine,
        'forms::components.text-input.actions.show-password' => Remix::EyeLine,
        'forms::components.toggle-buttons.boolean.false' => Remix::CloseLine,
        'forms::components.toggle-buttons.boolean.true' => Remix::CheckLine,

        // Forms: rich editor toolbar (Filament's own aliases use a single colon here)
        'forms:components.rich-editor.toolbar.align-center' => Remix::AlignCenter,
        'forms:components.rich-editor.toolbar.align-end' => Remix::AlignRight,
        'forms:components.rich-editor.toolbar.align-justify' => Remix::AlignJustify,
        'forms:components.rich-editor.toolbar.align-start' => Remix::AlignLeft,
        'forms:components.rich-editor.toolbar.attach-files' => Remix::Attachment2,
        'forms:components.rich-editor.toolbar.blockquote' => Remix::DoubleQuotesL,
        'forms:components.rich-editor.toolbar.bold' => Remix::Bold,
        'forms:components.rich-editor.toolbar.bullet-list' => Remix::ListUnordered,
        'forms:components.rich-editor.toolbar.clear_formatting' => Remix::FormatClear,
        'forms:components.rich-editor.toolbar.code' => Remix::CodeView,
        'forms:components.rich-editor.toolbar.code-block' => Remix::CodeBlock,
        'forms:components.rich-editor.toolbar.custom-blocks' => Remix::PuzzleLine,
        'forms:components.rich-editor.toolbar.details' => Remix::ListCheck3,
        'forms:components.rich-editor.toolbar.grid' => Remix::LayoutColumnLine,
        'forms:components.rich-editor.toolbar.grid_add_column_after' => Remix::InsertColumnRight,
        'forms:components.rich-editor.toolbar.grid_add_column_before' => Remix::InsertColumnLeft,
        'forms:components.rich-editor.toolbar.grid_delete' => Remix::DeleteBinLine,
        'forms:components.rich-editor.toolbar.grid_delete_column' => Remix::DeleteColumn,
        'forms:components.rich-editor.toolbar.h1' => Remix::H1,
        'forms:components.rich-editor.toolbar.h2' => Remix::H2,
        'forms:components.rich-editor.toolbar.h3' => Remix::H3,
        'forms:components.rich-editor.toolbar.h4' => Remix::H4,
        'forms:components.rich-editor.toolbar.h5' => Remix::H5,
        'forms:components.rich-editor.toolbar.h6' => Remix::H6,
        'forms:components.rich-editor.toolbar.highlight' => Remix::MarkPenLine,
        'forms:components.rich-editor.toolbar.horizontal-rule' => Remix::Separator,
        'forms:components.rich-editor.toolbar.italic' => Remix::Italic,
        'forms:components.rich-editor.toolbar.lead' => Remix::FontSize,
        'forms:components.rich-editor.toolbar.link' => Remix::LinksLine,
        'forms:components.rich-editor.toolbar.merge-tags' => Remix::BracesLine,
        'forms:components.rich-editor.toolbar.ordered-list' => Remix::ListOrdered,
        'forms:components.rich-editor.toolbar.paragraph' => Remix::Paragraph,
        'forms:components.rich-editor.toolbar.redo' => Remix::ArrowGoForwardLine,
        'forms:components.rich-editor.toolbar.small' => Remix::FontSize2,
        'forms:components.rich-editor.toolbar.strike' => Remix::Strikethrough,
        'forms:components.rich-editor.toolbar.subscript' => Remix::Subscript,
        'forms:components.rich-editor.toolbar.superscript' => Remix::Superscript,
        'forms:components.rich-editor.toolbar.table' => Remix::Table2,
        'forms:components.rich-editor.toolbar.table_add_column_after' => Remix::InsertColumnRight,
        'forms:components.rich-editor.toolbar.table_add_column_before' => Remix::InsertColumnLeft,
        'forms:components.rich-editor.toolbar.table_add_row_after' => Remix::InsertRowBottom,
        'forms:components.rich-editor.toolbar.table_add_row_before' => Remix::InsertRowTop,
        'forms:components.rich-editor.toolbar.table_delete' => Remix::DeleteBinLine,
        'forms:components.rich-editor.toolbar.table_delete_column' => Remix::DeleteColumn,
        'forms:components.rich-editor.toolbar.table_delete_row' => Remix::DeleteRow,
        'forms:components.rich-editor.toolbar.table_merge_cells' => Remix::MergeCellsHorizontal,
        'forms:components.rich-editor.toolbar.table_split_cell' => Remix::SplitCellsHorizontal,
        'forms:components.rich-editor.toolbar.table_toggle_header_cell' => Remix::LayoutLeftLine,
        'forms:components.rich-editor.toolbar.table_toggle_header_row' => Remix::LayoutTopLine,
        'forms:components.rich-editor.toolbar.text-color' => Remix::FontColor,
        'forms:components.rich-editor.toolbar.underline' => Remix::Underline,
        'forms:components.rich-editor.toolbar.undo' => Remix::ArrowGoBackLine,

        // Infolists
        'infolists::components.icon-entry.false' => Remix::CloseCircleLine,
        'infolists::components.icon-entry.true' => Remix::CheckboxCircleLine,

        // Notifications
        'notifications::database.modal.empty-state' => Remix::NotificationOffLine,
        'notifications::notification.close-button' => Remix::CloseLine,
        'notifications::notification.danger' => Remix::ErrorWarningLine,
        'notifications::notification.info' => Remix::InformationLine,
        'notifications::notification.success' => Remix::CheckboxCircleLine,
        'notifications::notification.warning' => Remix::AlertLine,

        // Query builder (Filament 4.0 used the tables:: prefix for the constraints)
        'query-builder::add-rule-action' => Remix::AddLine,
        'query-builder::constraints.boolean' => Remix::ToggleLine,
        'query-builder::constraints.date' => Remix::CalendarLine,
        'query-builder::constraints.number' => Remix::Hashtag,
        'query-builder::constraints.relationship' => Remix::LinksLine,
        'query-builder::constraints.select' => Remix::ExpandUpDownLine,
        'query-builder::constraints.text' => Remix::Text,
        'query-builder::or-group.add-group-action' => Remix::AddLine,
        'query-builder::or-group.block' => Remix::StackLine,
        'tables::filters.query-builder.constraints.boolean' => Remix::ToggleLine,
        'tables::filters.query-builder.constraints.date' => Remix::CalendarLine,
        'tables::filters.query-builder.constraints.number' => Remix::Hashtag,
        'tables::filters.query-builder.constraints.relationship' => Remix::LinksLine,
        'tables::filters.query-builder.constraints.select' => Remix::ExpandUpDownLine,
        'tables::filters.query-builder.constraints.text' => Remix::Text,

        // Schemas
        'schema::components.callout.danger' => Remix::ErrorWarningLine,
        'schema::components.callout.info' => Remix::InformationLine,
        'schema::components.callout.success' => Remix::CheckboxCircleLine,
        'schema::components.callout.warning' => Remix::AlertLine,
        'schema::components.tabs.dropdown-trigger-button' => Remix::ArrowDownSLine,
        'schema::components.tabs.more-tabs-button' => Remix::MoreLine,
        'schema::components.wizard.completed-step' => Remix::CheckLine,

        // Support
        'badge.delete-button' => Remix::CloseLine,
        'breadcrumbs.separator' => Remix::ArrowRightSLine,
        'breadcrumbs.separator.rtl' => Remix::ArrowLeftSLine,
        'modal.close-button' => Remix::CloseLine,
        'pagination.first-button' => Remix::ArrowLeftDoubleLine,
        'pagination.first-button.rtl' => Remix::ArrowRightDoubleLine,
        'pagination.last-button' => Remix::ArrowRightDoubleLine,
        'pagination.last-button.rtl' => Remix::ArrowLeftDoubleLine,
        'pagination.next-button' => Remix::ArrowRightSLine,
        'pagination.next-button.rtl' => Remix::ArrowLeftSLine,
        'pagination.previous-button' => Remix::ArrowLeftSLine,
        'pagination.previous-button.rtl' => Remix::ArrowRightSLine,
        'section.collapse-button' => Remix::ArrowUpSLine,

        // Tables
        'tables::actions.column-manager' => Remix::LayoutColumnLine,
        'tables::actions.disable-reordering' => Remix::CheckLine,
        'tables::actions.enable-reordering' => Remix::ArrowUpDownLine,
        'tables::actions.filter' => Remix::Filter3Line,
        'tables::actions.group' => Remix::StackLine,
        'tables::actions.open-bulk-actions' => Remix::More2Line,
        'tables::columns.collapse-button' => Remix::ArrowDownSLine,
        'tables::columns.icon-column.false' => Remix::CloseCircleLine,
        'tables::columns.icon-column.true' => Remix::CheckboxCircleLine,
        'tables::empty-state' => Remix::CloseLine,
        'tables::filters.remove-all-button' => Remix::CloseLine,
        'tables::grouping.collapse-button' => Remix::ArrowUpSLine,
        'tables::header-cell.sort-asc-button' => Remix::ArrowUpSLine,
        'tables::header-cell.sort-button' => Remix::ExpandUpDownLine,
        'tables::header-cell.sort-desc-button' => Remix::ArrowDownSLine,
        'tables::reorder.handle' => Remix::Draggable,
        'tables::search-field' => Remix::SearchLine,

        // Widgets
        'widgets::chart-widget.empty-state' => Remix::BarChartBoxLine,
        'widgets::chart-widget.filter' => Remix::Filter3Line,
    ];
}
