Public Class Character
    'Guild
    Public Name As String
    Public Rank As String
    Public Joined As String

    'Character
    Public ID As String
    Public Race As String
    Public Gender As String
    Public Profession As String
    Public Level As Integer 'The character's level
    Public Created As String 'ISO 8601 representation of the character's creation time.
    Public Age As String 'The amount of seconds this character was played.
    Public Deaths As String 'The amount of times this character has been defeated.
    Public Crafting As DisciplineList 'A list of objects of the character's crafting skills. An empty array is returned if the character has not learned a crafting discipline yet.
End Class
