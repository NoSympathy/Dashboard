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
    ' Public Guild As String ' The guild ID of the character's currently represented guild.
    Public Level As Integer 'The character's level
    Public Created As String 'ISO 8601 representation of the character's creation time.
    Public Age As String 'The amount of seconds this character was played.
    Public Deaths As String 'The amount of times this character has been defeated.
    Public Crafting As Array 'A list of objects of the character's crafting skills. An empty array is returned if the character has not learned a crafting discipline yet.

    'Guild
    Public Sub New(name As String, rank As String, joined As String)
        Me.Name = name
        Me.Rank = rank
        Me.Joined = joined
    End Sub

    'Ill Just create a new Sub, keeping yours short, sweet and simple

    'Character
    Public Sub New(id As String, name As String, rank As String, gender As String, race As String, profession As String, level As Integer, created As String, age As String, deaths As String, crafrting As Array)
        Me.ID = id
        Me.Name = name
        Me.Rank = rank
        Me.Race = race
        Me.Gender = gender
        Me.Profession = profession
        Me.Level = level
        Me.Created = created
        Me.Age = age
        Me.Deaths = deaths
        Me.Crafting = Crafting


    End Sub

End Class
