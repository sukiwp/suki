export default function hookAction(text) {
    switch (text) {
        case 'suki/frontend/before_canvas':
            return 'Before Page Canvas';
        case 'suki/frontend/after_canvas':
            return 'After Page Canvas';
        case 'suki/frontend/header':
            return 'Replace Header (Desktop & Mobile Header)';
        case 'suki/frontend/before_header':
            return 'Before Header';
        case 'suki/frontend/after_header':
            return 'After Header';
        case 'suki/frontend/before_primary_and_sidebar':
            return 'Before Main Content & Sidebar';
        case 'suki/frontend/before_primary_and_sidebar':
            return 'After Main Content & Sidebar';
        case 'suki/frontend/before_main':
            return 'Before Main Content';
        case 'suki/frontend/after_main':
            return 'After Main Content';
        case 'suki/frontend/before_sidebar':
            return 'Before Sidebar';
        case 'suki/frontend/after_sidebar':
            return 'After Sidebar';
        case 'suki/frontend/entry/before_header':
            return 'Before Post Entry Header';
        case 'suki/frontend/entry/header':
            return 'Post Entry Header';
        case 'suki/frontend/entry/after_header':
            return 'After Post Entry Header';
        case 'suki/frontend/entry/before_content':
            return 'Before Post Entry Content';
        case 'suki/frontend/entry/after_content':
            return 'After Post Entry Content';
        case 'suki/frontend/entry/before_footer':
            return 'Before Post Entry Footer';
        case 'suki/frontend/entry/footer':
            return 'Post Entry Footer';
        case 'suki/frontend/entry/after_footer':
            return 'After Post Entry Footer';
        case 'suki/frontend/before_comments':
            return 'Before Comments Section';
        case 'suki/frontend/before_comments_list':
            return 'Before Comments List';
        case 'suki/frontend/after_comments_list':
            return 'After Comments List';
        case 'suki/frontend/after_comments':
            return 'After Comments Section';
        case 'suki/frontend/footer':
            return 'Replace Footer (Widgets & Bottom Bar)';
        case 'suki/frontend/before_footer':
            return 'Before Footer';
        case 'suki/frontend/after_footer':
            return 'After Footer';
        default:
            return 'Attached Hook, Not Register';
    }
}
