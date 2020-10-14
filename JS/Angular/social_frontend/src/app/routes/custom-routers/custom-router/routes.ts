export const customRoutes = [
    {
        name: 'userPage',
        condition: 'id([0-9]+)',
        params: ['id']
    },
    {
        name: 'publicPage',
        condition: 'public([0-9]+)',
        params: ['id']
    },
    {
        name: 'groupPage',
        condition: 'club([0-9]+)',
        params: ['id']
    },
    {
        name: 'photo',
        condition: 'photo([0-9]+)_([0-9]+)',
        params: ['id', 'photo_id']
    },
    {
        name: 'video',
        condition: 'video([0-9]+)_([0-9]+)',
        params: ['id', 'video_id']
    },
    {
        name: 'audio',
        condition: 'audios([0-9]+)',
        params: ['id']
    },
]
